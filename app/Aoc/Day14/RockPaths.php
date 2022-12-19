<?php

namespace App\Aoc\Day14;

use Illuminate\Support\Collection;

class RockPaths extends Collection
{
    // find min/max x/y values from RockPath Coordinates
    public function xMinimum(): int
    {
        return $this->reduce(function (int $c, RockPath $path) {
            return min($c, $path->xMinimum());
        }, PHP_INT_MAX);
    }

    public function xMaximum(): int
    {
        return $this->reduce(function (int $c, RockPath $path) {
            return max($c, $path->xMaximum());
        }, 0);
    }

    public function yMinimum(): int
    {
        return $this->reduce(function (int $c, RockPath $path) {
            return min($c, $path->yMinimum());
        }, PHP_INT_MAX);
    }

    public function yMaximum(): int
    {
        return $this->reduce(function (int $c, RockPath $path) {
            return max($c, $path->yMaximum());
        }, 0);
    }
}
