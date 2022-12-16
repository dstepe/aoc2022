<?php

namespace App\Aoc\Day12;

use Illuminate\Support\Collection;

class Seeker
{
    private Map $map;
    private Position $start;
    private Position $end;

    private Collection $routes;

    private Collection $possibleRoutes;
    private int $shortestRoute;

    public function __construct(Map $map)
    {
        $this->map = $map;

        $this->start = $this->map->start();
        $this->end = $this->map->end();

        $this->routes = new Collection();
    }

    public function seekRoutes(): void
    {
        $this->routesFrom($this->start);

        $this->possibleRoutes = $this->routes->filter(function (Collection $path) {
            return $path->last() === $this->end->location();
        });

        $this->shortestRoute = $this->possibleRoutes->reduce(function (int $c, Collection $path) {
            return min($c, $path->count());
        }, $this->map->size()) - 1;
    }

    public function shortestRoute(): int
    {
        return $this->shortestRoute;
    }
    
    private function routesFrom(Position $position, Collection $path = null): Collection
    {
        if ($path === null) {
            $path = new Collection();
        }

        $options = $this->getMoveOptionsFor($position);

        $path = $path->merge([$position->location()]);

        $options->each(function (Position $neighbor) use ($path) {
            if ($path->contains($neighbor->location())) {
                return;
            }

            $this->routes->add($this->routesFrom($neighbor, $path));
        });

        return $path;
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
}
