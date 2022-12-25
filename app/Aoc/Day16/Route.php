<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Route extends Collection
{
    public function potentialBenefit(int $fromStep = 0): float
    {
        if ($this->isEmpty()) {
            return 0;
        }

        $offset = $this->count() - $fromStep;

        /** @var Valve $last */
        $last = $this->last();

        if ($offset <= 1) {
            return $last->flowRate();
        }

        return $last->flowRate() / ($offset - 1);
    }

    public function path(): string
    {
        return $this->reduce(function (Collection $c, Valve $valve) {
            $c->add($valve->label());
            return $c;
        }, new Collection())->implode(', ');
    }
}
