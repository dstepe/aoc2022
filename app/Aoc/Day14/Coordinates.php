<?php

namespace App\Aoc\Day14;

class Coordinates
{
    private int $x;
    private int $y;

    private function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function fromString(string $pair): self
    {
        [$x, $y] = explode(',', $pair);

        return new self($x, $y);
    }

    public static function fromInts(int $x, int $y): self
    {
        return new self($x, $y);
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function pair(): string
    {
        return sprintf('%s:%s', $this->x, $this->y);
    }
}
