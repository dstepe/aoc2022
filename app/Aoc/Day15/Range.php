<?php

namespace App\Aoc\Day15;

class Range
{
    private Point $from;
    private Point $to;

    public function __construct(Point $from, Point $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function label(): string
    {
        return sprintf('%s .. %s', $this->from->label(), $this->to->label());
    }

    public function rowNum(): int
    {
        return $this->from->y();
    }

    public function span(): int
    {
        return abs($this->to->x() - $this->from->x()) + 1;
    }

    public function contains(Point $point): bool
    {
        if ($point->y() !== $this->from->y()) {
            return false;
        }

        return $this->from->x() <= $point->x() && $this->to->x() >= $point->x();
    }
}
