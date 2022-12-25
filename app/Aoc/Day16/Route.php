<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Route extends Collection
{
    public function potentialValue(int $timeRemaining): int
    {
        /** @var Valve $valve */
        $valve = $this->last();

        return $valve->potentialPressure($timeRemaining - $this->count());
    }

    public function path(): string
    {
        return $this->reduce(function (Collection $c, Valve $valve) {
            $c->add($valve->label());
            return $c;
        }, new Collection())->implode(', ');
    }
}
