<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Mapper
{
    private Valves $valves;

    public function __construct(Valves $valves)
    {
        $this->valves = $valves;
    }

    public function findRoute(Valve $from, Valve $to): Route
    {
        if ($from->leadsTo($to->label())) {
            return new Route([$from, $to]);
        }

        $frontier = new Collection();
        $frontier->add($from);

        $cameFrom = new Collection();
        $cameFrom->put($from->label(), $from);

        while ($frontier->isNotEmpty()) {
            /** @var Valve $current */
            $current = $frontier->shift();

            if ($current->label() === $to->label()) {
                return $this->makeRoute($to, $from, $cameFrom);
            }

            $this->valves->connections($current)->each(function (Valve $neighbor) use ($frontier, $cameFrom, $current) {
                if ($cameFrom->has($neighbor->label())) {
                    return;
                }

                $frontier->add($neighbor);
                $cameFrom->put($neighbor->label(), $current);
            });
        }

        throw new \Exception('Unable to find path to valve');
    }

    private function makeRoute(Valve $to, Valve $start, Collection $cameFrom): Route
    {
//        printf("Start %s to %s\n", $start->label(), $to->label());
//        $cameFrom->each(function (Valve $valve, string $key) {
//            printf("Valve %s came from %s\n", $key, $valve->label());
//        });
        $route = new Route();

        $valve = $to;

        while ($valve->label() !== $start->label()) {
            /** @var Valve $from */
            $from = $cameFrom->get($valve->label());
            $route->add($from);

            $valve = $from;
        }

        $route = $route->reverse()->add($to)->values();

//        $route->each(function (Valve $valve) {
//            printf("Step %s\n", $valve->label());
//        });

        return $route;
    }
/*
frontier = Queue()
frontier.put(start )
came_from = dict()
came_from[start] = None

while not frontier.empty():
   current = frontier.get()

   if current == goal:
      break

   for next in graph.neighbors(current):
      if next not in came_from:
         frontier.put(next)
         came_from[next] = current
 */
}
