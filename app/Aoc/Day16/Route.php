<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Route extends Collection
{
    public function potentialBenefit(): float
    {
        /** @var Valve $last */
        $last = $this->last();

        if ($this->count() <= 1) {
            return $last->flowRate();
        }

        return $last->flowRate() / ($this->count() - 1);
    }

    public function path(): string
    {
        return $this->reduce(function (Collection $c, Valve $valve) {
            $c->add($valve->label());
            return $c;
        }, new Collection())->implode(', ');
    }
}
