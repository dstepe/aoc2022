<?php

namespace App\Aoc\Day16;

interface TimedEvent
{
    public function tick(int $minute, int $remaining): void;
}
