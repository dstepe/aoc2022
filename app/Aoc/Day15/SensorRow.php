<?php

namespace App\Aoc\Day15;

use Illuminate\Support\Collection;

class SensorRow
{
    private int $rowNum;

    private Collection $knownBeacons;

    private ?int $start = null;
    private ?int $end = null;

    private Collection $ranges;
    private Collection $mergedRanges;

    public function __construct(int $rowNum, Collection $knownBeacons)
    {
        $this->rowNum = $rowNum;
        $this->knownBeacons = $knownBeacons;
        $this->ranges = new Collection();
        $this->mergedRanges = new Collection();
    }

    public function checkSensor(Sensor $sensor): void
    {
        if ($sensor->notCoversRow($this->rowNum)) {
            return;
        }

        $this->startCandidate($sensor->coversFromX());
        $this->endCandidate($sensor->coversToX());

        $range = $sensor->positionsSeenInRow($this->rowNum);
        $this->ranges->add($range);
        $this->mergeRange($range);

        $this->mergedRanges = $this->mergedRanges->sort(function (Range $a, Range $b) {
            if ($a->fromX() === $b->fromX()) {
                return 0;
            }

            return $a->fromX() < $b->fromX() ? -1 : 1;
        });
    }

    public function excluded(): int
    {
        return $this->mergedRanges->reduce(function (int $c, Range $range) {
            return $c + $range->span();
        }, 0);
    }

    public function ranges(): Collection
    {
        return $this->ranges;
    }

    public function mergedRanges(): Collection
    {
        return $this->mergedRanges;
    }

    public function uncoveredInRange(int $start, int $end): Collection
    {
        $uncovered = new Collection();

        if ($this->mergedRanges->count() === 1) {
            return $uncovered;
        }

        // slide over ranges finding gaps between to x and from x
        $this->mergedRanges->sliding(2)->eachSpread(function (Range $a, Range $b) use ($uncovered) {
            $from = $a->toX() + 1;
            $to = $b->fromX();

            for ($i = $from; $i < $to; $i++) {
                $uncovered->add(new Point($i, $this->rowNum));
            }
        });

        return $uncovered;
    }

    private function startCandidate(int $candidate): void
    {
        if ($this->start === null) {
            $this->start = $candidate;
            return;
        }

        if ($this->start <= $candidate) {
            return;
        }

        $this->start = $candidate;
    }

    private function endCandidate(int $candidate): void
    {
        if ($this->end === null) {
            $this->end = $candidate;
            return;
        }

        if ($this->end >= $candidate) {
            return;
        }

        $this->end = $candidate;
    }

    private function mergeRange(Range $range): void
    {
//        printf("Considering range %s\n", $range->label());
        $overlappedRanges = $this->mergedRanges->filter(function(Range $known) use ($range) {
            return ($known->contains($range->from()) || $known->contains($range->to()))
                || ($range->contains($known->from()) || $range->contains($known->to()));
        })->values();

        if ($overlappedRanges->isEmpty()) {
//            printf("No overlap for %s, adding\n", $range->label());
            $this->mergedRanges->add($range);
            return;
        }

        if ($overlappedRanges->count() > 1) {
            /** @var Range $overlappedRange1 */
            $overlappedRange1 = $overlappedRanges->first();
            /** @var Range $overlappedRange2 */
            $overlappedRange2 = $overlappedRanges->last();
            $from = min($range->fromX(), $overlappedRange1->fromX(), $overlappedRange2->fromX());
            $to = max($range->toX(), $overlappedRange1->toX(), $overlappedRange2->toX());

            $removeLabels = $overlappedRanges->reduce(function (array $c, Range $range) {
                $c[] = $range->label();
                return $c;
            }, []);

            $this->mergedRanges = $this->mergedRanges->reject(function (Range $range) use ($removeLabels) {
//                if (in_array($range->label(), $removeLabels, true)) {
//                    printf("Rejecting %s after merge\n", $range->label());
//                }
                return in_array($range->label(), $removeLabels, true);
            });

            $merged = new Range(new Point($from, $this->rowNum), new Point($to, $this->rowNum));
//            printf("Adding new merged range %s\n", $merged->label());
            $this->mergedRanges->add($merged);

            return;
        }

        if ($overlappedRanges->count() === 1) {
            /** @var Range $known */
            $known = $overlappedRanges->first();

            if ($known->contains($range->from()) && $known->contains($range->to())) {
//                printf("Skipping contained range %s\n", $range->label());
                return;
            }

            $this->mergedRanges = $this->mergedRanges->reject(function (Range $range) use ($known) {
//                if ($range->label() === $known->label()) {
//                    printf("Rejecting %s after extending\n", $range->label());
//                }
                return $range->label() === $known->label();
            });

            $from = min($range->fromX(), $known->fromX());
            $to = max($range->toX(), $known->toX());
            $new = new Range(new Point($from, $this->rowNum), new Point($to, $this->rowNum));
            $this->mergedRanges->add($new);
//            printf("Added extended range %s\n", $new->label());

            return;
        }

        printf("Range %s\n\n", $range->label());
        $this->mergedRanges->each(function (Range $range) {
            printf("Merged range %s\n", $range->label());
        });
        print "\n";
        $overlappedRanges->each(function (Range $range) {
            printf("Overlapped range %s\n", $range->label());
        });
        throw new \Exception(sprintf('Unexpected condition with ranges, count %s', $overlappedRanges->count()));
    }
}
