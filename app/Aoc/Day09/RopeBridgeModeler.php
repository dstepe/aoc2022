<?php

namespace App\Aoc\Day09;

class RopeBridgeModeler
{
    private \Iterator $input;
    private Bridge $bridge;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->bridge = new Bridge();
    }

    public function processMoves(): void
    {
        foreach ($this->input as $move) {
            [$direction, $steps] = explode(' ', $move);
            $this->bridge->move($direction, $steps);
        }
    }

    public function map(): string
    {
        return $this->bridge->occupantMap();
    }

    public function visited(): string
    {
        return $this->bridge->visitedMap();
    }

    public function visitedCount(): int
    {
        return $this->bridge->visitedCount();
    }
}
