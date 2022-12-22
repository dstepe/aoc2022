<?php

namespace App\Aoc\Day15;

class Point
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function label(): string
    {
        return sprintf('%s,%s', $this->x, $this->y);
    }

    public function tuningFrequency(): int
    {
        return ($this->x * 4000000) + $this->y;
    }
}
