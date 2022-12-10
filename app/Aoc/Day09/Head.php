<?php

namespace App\Aoc\Day09;

class Head extends Occupant
{
    public const MARKER = 'H';

    protected int $order = 1;

    protected string $occupantMarker = self::MARKER;

}
