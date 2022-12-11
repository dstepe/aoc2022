<?php

namespace App\Aoc\Day10;

use Illuminate\Support\Collection;
use PhpParser\Node\Expr\List_;

class Clock
{
    private Collection $listeners;

    private int $cycle = 0;
    public function __construct()
    {
        $this->listeners = new Collection();
    }

    public function addListener(ClockListener $listener): void
    {
        $this->listeners->add($listener);
    }

    public function tick(): void
    {
        $this->cycle++;

        $this->listeners->each(function (ClockListener $listener) {
            $listener->tick($this->cycle);
        });
    }
}
