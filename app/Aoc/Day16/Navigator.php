<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Navigator implements TimedEvent
{
    private Valves $valves;

    private Mapper $mapper;
    private Valve $current;

    public function __construct(Valves $valves)
    {
        $this->valves = $valves;

        $this->mapper = new Mapper($this->valves);
        $this->current = $this->valves->first();
    }

    public function tick(): void
    {
        try {
            $move = $this->bestNextMove($this->current);
        } catch (\Exception $e) {
            printf("Error %s\n", $e->getMessage());
            return;
        }

        printf("Current cost to obtain %s, next cost to obtain %s\n", $this->current->flowRate(), $move->potentialBenefit());
        if ($this->current->isClosed() && $this->current->flowRate() >= $move->potentialBenefit()) {
            printf("Let's open %s first\n", $this->current->label());
            $this->current->open();
            return;
        }

        /** @var Valve $target */
        $target = $move->last();
        /** @var Valve $next */
        $next = $move->get(1);
        printf("Let's move toward %s, next is %s along %s\n", $target->label(), $next->label(), $move->path());

        $this->current = $next;
    }

    public function bestNextMove(Valve $from): Route
    {
        /** @var Collection $candidates */
        $candidates = $this->valves->priorities()
            ->reduce(function (Collection $c, Valve $valve) use ($from) {
                if ($valve->flowRate() === 0) {
                    return $c;
                }

                $route = $this->mapper->findRoute($from, $valve);

                if ($route->isNotEmpty()) {
                    $c->add($route);
                }

                return $c;
            }, new Collection())->sort(function (Route $a, Route $b) {
                return $b->potentialBenefit() <=> $a->potentialBenefit();
            })->values();

        if ($candidates->isEmpty()) {
            throw new \Exception(sprintf("No best move from %s", $from->label()));
        }

        $candidates->each(function (Route $route) {
            printf("Route %s has benefit %s\n", $route->path(), $route->potentialBenefit());
        });

        return $candidates->first();
    }
}
