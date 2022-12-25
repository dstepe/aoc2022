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

    public function tick(int $minute, $remaining): void
    {
//        printf(
//            "Current %s benefit %s, route benefit %s\n",
//            $this->currentValve->label(),
//            $this->currentValve->isOpen() ? 0 : $this->currentValve->flowRate(),
//            $this->currentRoute->potentialPressure($minute)
//        );

        if ($this->shouldOpenValve()) {
            printf("Let's open %s first\n", $this->currentValve->label());
            $this->currentValve->open();
            $this->stepInCurrentRoute++;
            return;
        }

        try {
            $this->getNextRoute($remaining);
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

    private function getNextRoute(int $remaining): void
    {
        if ($this->stepInCurrentRoute < $this->currentRoute->count()) {
            return;
        }

        $this->currentRoute = $this->bestNextMove($this->currentValve, $remaining);
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

        return false;
    }

    public function bestNextMove(Valve $from, int $remaining): Route
    {
        /** @var Collection $candidates */
        $candidates = $this->valves->candidateValves()
            ->reduce(function (Collection $c, Valve $valve) use ($from) {
                $route = $this->mapper->findRoute($from, $valve);

                if ($route->isNotEmpty()) {
                    $c->add($route);
                }

                return $c;
            }, new Collection())->sort(function (Route $a, Route $b) use ($remaining) {
                return $b->potentialValue($remaining) <=> $a->potentialValue($remaining);
            })->values();

        if ($candidates->isEmpty()) {
            throw new \Exception(sprintf("No best move from %s", $from->label()));
        }

        /*
         * JJ 21 * (30 - 3) = 567
         * DD 20 * (30 - 2) = 560
         */
        $candidates->each(function (Route $route) use ($remaining) {
            printf("Route %s has potential %s with %s remaining\n", $route->path(), $route->potentialValue($remaining), $remaining);
        });

        return $candidates->first();
    }
}
