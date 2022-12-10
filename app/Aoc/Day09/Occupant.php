<?php

namespace App\Aoc\Day09;

abstract class Occupant
{
    protected string $occupantMarker;

    protected int $order = 10;

    protected bool $visits = false;

    public function marker(): string
    {
        return $this->occupantMarker;
    }

    public function order(): int
    {
        return $this->order;
    }

    public function shouldVisit(): bool
    {
        return $this->visits;
    }

    public function enters(Position $position): void
    {
        $position->arrives($this);
    }

    public function leaves(Position $position): void
    {
        $position->leaves($this);
    }
}
