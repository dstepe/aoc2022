<?php

namespace App\Aoc\Day11;

class Item
{
    private int $worryLevel;

    public function __construct(int $worryLevel)
    {
        $this->worryLevel = $worryLevel;
    }

    public function worryLevel(): int
    {
        return $this->worryLevel;
    }
}
