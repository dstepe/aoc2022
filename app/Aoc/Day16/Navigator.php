<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Navigator implements TimedEvent
{
    private Valves $valves;

    private Mapper $mapper;
    private Valve $currentValve;
    private Route $currentRoute;
    private int $stepInCurrentRoute = 1;

    public function __construct(Valves $valves)
    {
        $this->valves = $valves;

        $this->mapper = new Mapper($this->valves);
        $this->currentRoute = new Route();
        $this->currentValve = $this->valves->get('AA');
    }

    public function tick(): void
    {
        printf(
            "Current %s benefit %s, route benefit %s\n",
            $this->currentValve->label(),
            $this->currentValve->isOpen() ? 0 : $this->currentValve->flowRate(),
            $this->currentRoute->potentialBenefit()
        );

        if ($this->shouldOpenValve()) {
            printf("Let's open %s first\n", $this->currentValve->label());
            $this->currentValve->open();
            $this->stepInCurrentRoute++;
            return;
        }

        try {
            $this->getNextRoute();
        } catch (\Exception $e) {
            printf("Error %s\n", $e->getMessage());
            return;
        }

        /** @var Valve $target */
        $target = $this->currentRoute->last();
        /** @var Valve $next */
        $this->currentValve = $this->currentRoute->get($this->stepInCurrentRoute);
        $this->stepInCurrentRoute++;

        printf(
            "Let's move toward %s, next is %s along %s\n",
            $target->label(),
            $this->currentValve->label(),
            $this->currentRoute->path()
        );
    }

    private function getNextRoute(): void
    {
        if ($this->stepInCurrentRoute < $this->currentRoute->count()) {
            return;
        }

        $this->currentRoute = $this->bestNextMove($this->currentValve);
        $this->stepInCurrentRoute = 1;
    }

    private function shouldOpenValve(): bool
    {
        if ($this->currentValve->isOpen() || $this->currentValve->flowRate() === 0) {
            return false;
        }

        if ($this->stepInCurrentRoute === $this->currentRoute->count()) {
            return true;
        }

        // Adjusted for move cost
        if ($this->currentValve->flowRate() + 1 >= $this->currentRoute->potentialBenefit($this->stepInCurrentRoute)) {
            return true;
        }

        return false;
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
                $diff = $b->count() - $a->count();
                $adjustment = $diff >= 1 ? $diff : 0;

//                printf("Sort %s (%s) against %s (%s + %s)\n", $b->path(), $b->potentialBenefit(), $a->path(), $a->potentialBenefit(), $adjustment);

                return $b->potentialBenefit() <=> $a->potentialBenefit() + $adjustment;
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
