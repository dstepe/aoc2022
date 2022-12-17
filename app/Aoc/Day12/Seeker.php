<?php

namespace App\Aoc\Day12;

use Illuminate\Support\Collection;

class Seeker
{
    private Map $map;
    private Position $start;
    private Position $end;

    private Collection $shortestRoute;

    public function __construct(Map $map)
    {
        $this->map = $map;

        $this->start = $this->map->start();
        $this->end = $this->map->end();

        $this->routes = new Collection();
    }

    public function seekRoutes(): void
    {
        $start = $this->start;

        $frontier = new Frontier();
        $frontier->enqueue($start, 0);

        $cameFrom = new Collection();
        $cameFrom->put($start->location(), $start);

        $costSoFar = new Collection();
        $costSoFar->put($start->location(), 0);

        while ($frontier->isNotEmpty()) {
            $current = $frontier->dequeue();

            if ($current->isEnd()) {
                $this->createPathFrom($cameFrom);
                return;
            }

            $currentCost = $costSoFar->get($current->location());

            /** @var Position $next */
            foreach ($this->getMoveOptionsFor($current) as $next) {
                $newCost = $currentCost + ($next->height() - $current->height()) + 1;

                if (!$costSoFar->has($next->location()) || $newCost < $costSoFar->get($next->location())) {
                    $costSoFar->put($next->location(), $newCost);
                    $priority = $newCost + $this->h($next);
                    $frontier->enqueue($next, $priority);
                    $cameFrom->put($next->location(), $current);
                }
            }
        }

        $this->createPathFrom($cameFrom);

        throw new \Exception('Unable to find path to end');
    }

    public function shortestRoute(): Collection
    {
        return $this->shortestRoute;
    }

    private function h(Position $position): int
    {
        return abs($this->end->row() - $position->row())
            + abs($this->end->column() - $position->column());
    }

    private function getMoveOptionsFor(Position $position): Collection
    {
        $options = new Collection();

        if ($position->canMoveUp()) {
            $options->add($position->upNeighbor());
        }

        if ($position->canMoveRight()) {
            $options->add($position->rightNeighbor());
        }

        if ($position->canMoveDown()) {
            $options->add($position->downNeighbor());
        }

        if ($position->canMoveLeft()) {
            $options->add($position->leftNeighbor());
        }

        return $options;
    }

    private function createPathFrom(Collection $cameFrom): void
    {
        $route = new Collection();

        $position = $cameFrom->last();

        while ($position->isNot($this->start)) {
            /** @var Position $from */
            $from = $cameFrom->get($position->location());
            $route->add($from);

            $from->leaveFor($position);

            $position = $from;
        }

        $this->shortestRoute = $route->reverse();
    }
}
