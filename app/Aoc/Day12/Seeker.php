<?php

namespace App\Aoc\Day12;

use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;

class Seeker
{
    private Map $map;
    private OutputStyle $output;

    private Position $start;
    private Position $end;

    private Collection $shortestRoute;

    public function __construct(Map $map, OutputStyle $output)
    {
        $this->map = $map;
        $this->output = $output;

        $this->start = $this->map->start();
        $this->end = $this->map->end();

        $this->routes = new Collection();
    }

    public function seekRoutes(string $label): void
    {
        $startingPoints = $this->map->findAll($label);

        $progress = $this->output->createProgressBar($startingPoints->count());
        $progress->start();

        $this->shortestRoute = $startingPoints->reduce(function (?Collection $c, Position $start) use ($progress) {
            try {
                $route = $this->seekRouteFrom($start);
                if ($c === null) {
                    $c = $route;
                }

                $c = $route->count() < $c->count() ? $route : $c;
            } catch (\Exception $e) {

            }

            $progress->advance();

            return $c;
        });

        $progress->finish();

        $this->mapVisited($this->shortestRoute);
    }

    public function seekRouteFrom(Position $start): Collection
    {
        $frontier = new Frontier();
        $frontier->enqueue($start, 0);

        $cameFrom = new Collection();
        $cameFrom->put($start->location(), $start);

        $costSoFar = new Collection();
        $costSoFar->put($start->location(), 0);

        while ($frontier->isNotEmpty()) {
            $current = $frontier->dequeue();

            if ($current->isEnd()) {
                return $this->makeRouteFrom($start, $cameFrom);
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

    private function makeRouteFrom(Position $start, Collection $cameFrom): Collection
    {
        $route = new Collection();

        $position = $cameFrom->last();

        while ($position->isNot($start)) {
            /** @var Position $from */
            $from = $cameFrom->get($position->location());
            $route->add($from);

            $position = $from;
        }

        return $route->reverse();
    }

    private function mapVisited(Collection $path): void
    {
        $length = $path->count();
        for ($i = 0; $i < $length; $i++) {
            /** @var Position $position */
            $position = $path->get($i);

            /** @var Position $neighbor */
            $neighbor = $path->get($i + 1);

            if ($neighbor === null) {
                continue;
            }
            
            $neighbor->leaveFor($position);
        }
    }
}
