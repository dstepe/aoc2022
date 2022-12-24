<?php

namespace App\Aoc\Day16;

interface TimedEvent
{
    public function tick(): void;
}
