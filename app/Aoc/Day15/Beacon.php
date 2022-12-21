<?php

namespace App\Aoc\Day15;

class Beacon
{

    private Point $point;

    public function __construct(Point $point)
    {
        $this->point = $point;
    }

    public function x(): int
    {
        return $this->point->x();
    }

    public function y(): int
    {
        return $this->point->y();
    }

    public function label(): string
    {
        return $this->point->label();
    }
}
