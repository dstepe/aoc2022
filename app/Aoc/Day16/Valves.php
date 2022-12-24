<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Valves extends Collection
{
    public function makeValveFromDescription(string $description): Valve
    {
        if (!preg_match('/Valve (\w+) has flow rate=(\d+); tunnels? leads? to valves? (.*)/', $description, $parts)) {
            throw new \InvalidArgumentException(sprintf('Could not parse valve description: %s', $description));
        }

        $valve = new Valve($parts[1], $parts[2], new Collection(explode(', ', $parts[3])));

        $this->put($valve->label(), $valve);

        return $valve;
    }

    public function connections(Valve $from): Collection
    {
        return $this->filter(function (Valve $valve) use ($from) {
            return $from->leadsTo($valve->label());
        });
    }

    public function priorities(): Collection
    {
        return $this->reduce(function (Collection $c, Valve $valve) {
            if ($valve->isClosed()) {
                $c->add($valve);
            }
            return $c;
        }, new Collection())->sort(function (Valve $a, Valve $b) {
            return $a->flowRate() <=> $b->flowRate();
        });
    }
}
