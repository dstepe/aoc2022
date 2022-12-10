<?php

namespace App\Aoc\Day09;

class Start extends Occupant
{
    public const MARKER = 's';

    protected int $order = 5;

    protected bool $visits = true;

    protected string $occupantMarker = self::MARKER;

    public function leaves(Position $position): void
    {
        throw new \Exception('Start occupant cannot leave position');
    }
}
