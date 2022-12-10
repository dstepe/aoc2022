<?php

namespace App\Aoc\Day04;

class SectionAssignment
{
    private int $rangeStart;
    private int $rangeEnd;

    public function __construct(string $range)
    {
        [$this->rangeStart, $this->rangeEnd] = explode('-', $range);
    }

    public function rangeStart(): int
    {
        return $this->rangeStart;
    }

    public function rangeEnd(): int
    {
        return $this->rangeEnd;
    }

    public function contains(SectionAssignment $assignment): bool
    {
        return $this->between($assignment->rangeStart(), $this->rangeStart, $this->rangeEnd)
            && $this->between($assignment->rangeEnd(), $this->rangeStart, $this->rangeEnd);
    }

    public function overlaps(SectionAssignment $assignment): bool
    {
        return $this->between($assignment->rangeStart(), $this->rangeStart, $this->rangeEnd)
            || $this->between($assignment->rangeEnd(), $this->rangeStart, $this->rangeEnd);
    }

    private function between(int $subject, int $low, int $high): bool
    {
        return $subject >= $low && $subject <= $high;
    }
}
