<?php

namespace App\Aoc\Day10;

interface ClockListener
{
    public function tick(int $cycle): void;
}
