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

    public function __construct(int $rowNum, Collection $knownBeacons)
    {
        $this->rowNum = $rowNum;
        $this->knownBeacons = $knownBeacons;
        $this->ranges = new Collection();
    }

    public function checkSensor(Sensor $sensor): void
    {
        if ($sensor->notCoversRow($this->rowNum)) {
            return;
        }

        $this->startCandidate($sensor->coversFromX());
        $this->endCandidate($sensor->coversToX());

        $this->ranges->add($sensor->positionsSeenInRow($this->rowNum));
    }

    public function excluded(): int
    {
        $excluded = 0;

        for ($i = $this->start; $i <= $this->end; $i++) {
            $point = new Point($i, $this->rowNum);
            if ($i % 10000 === 0) {
                print "Scanned $i\n";
            }
            $this->ranges->each(function (Range $range) use (&$excluded, $point) {
                if ($this->knownBeacons->has($point->label())) {
                    return true;
                }

                if ($range->contains($point)) {
                    $excluded++;
                    return false; // no need to continue
                }
                return true;
            });
        }

        return $excluded;
    }

    public function ranges(): Collection
    {
        return $this->ranges;
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
}
