<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class PressureMonitor implements TimedEvent
{
    private Valves $valves;

    private int $releasedPressure = 0;

    public function __construct(Valves $valves)
    {
        $this->valves = $valves;
    }

    public function tick(int $minute, int $remaining): void
    {
        $open = new Collection();
        $increment = $this->valves->reduce(function (int $c, Valve $valve) use ($open) {
            if ($valve->isClosed()) {
                return $c;
            }

            $open->add($valve->label());

            return $c + $valve->flowRate();
        }, 0);

        if ($open->isEmpty()) {
            print "No valves are open\n";
            return;
        }

        printf("Valves %s are open, releasing %s pressure\n", $open->implode(', '), $increment);

        $this->releasedPressure += $increment;
    }

    public function releasedPressure(): int
    {
        return $this->releasedPressure;
    }
}
