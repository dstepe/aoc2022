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

        if ($overlappedRanges->count() === 2) {
            /** @var Range $overlappedRange1 */
            $overlappedRange1 = $overlappedRanges->get(0);
            /** @var Range $overlappedRange2 */
            $overlappedRange2 = $overlappedRanges->get(1);
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

        throw new \Exception('Unexpected condition with ranges');
    }
}
