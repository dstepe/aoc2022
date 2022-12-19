<?php

namespace App\Aoc\Day14;

use Illuminate\Support\Collection;

class RockPath extends Collection
{
    public function xMinimum(): int
    {
        return $this->reduce(function (int $c, Coordinates $coordinates) {
            return min($c, $coordinates->x());
        }, PHP_INT_MAX);
    }

    public function xMaximum(): int
    {
        return $this->reduce(function (int $c, Coordinates $coordinates) {
            return max($c, $coordinates->x());
        }, 0);
    }

    public function yMinimum(): int
    {
        return $this->reduce(function (int $c, Coordinates $coordinates) {
            return min($c, $coordinates->y());
        }, PHP_INT_MAX);
    }

    public function yMaximum(): int
    {
        return $this->reduce(function (int $c, Coordinates $coordinates) {
            return max($c, $coordinates->y());
        }, 0);
    }

    public function makePath(): Collection
    {
       $segments = new Collection();

       $this->sliding(2)->eachSpread(function (Coordinates $from, Coordinates $to) use ($segments) {
           $segments->add($this->getSegment($from, $to));
       });

       return $segments->reduce(function (Collection $c, Collection $segment) {
           return $c->merge($segment);
       }, new Collection())->unique(function (Coordinates $coordinates) {
           return $coordinates->pair();
       })->values();
    }

    private function getSegment(Coordinates $from, Coordinates $to): Collection
    {
        $segment = new Collection();

        if ($from->y() === $to->y()) {
            // x path
            if ($from->x() < $to->x()) {
                for ($i = $from->x(); $i <= $to->x(); $i++) {
                    $segment->add(Coordinates::fromInts($i, $from->y()));
                }
            } else {
                for ($i = $from->x(); $i >= $to->x(); $i--) {
                    $segment->add(Coordinates::fromInts($i, $from->y()));
                }
            }
        } else {
            // y path
            if ($from->y() < $to->y()) {
                for ($i = $from->y(); $i <= $to->y(); $i++) {
                    $segment->add(Coordinates::fromInts($from->x(), $i));
                }
            } else {
                for ($i = $from->y(); $i >= $to->y(); $i--) {
                    $segment->add(Coordinates::fromInts($from->x(), $i));
                }
            }
        }

        return $segment;
    }
}
