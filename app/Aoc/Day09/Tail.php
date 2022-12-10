<?php

namespace App\Aoc\Day09;

class Tail extends Occupant
{
    public const MARKER = 'T';

    protected int $order = 3;

    protected bool $visits = true;

    protected string $occupantMarker = self::MARKER;

}
