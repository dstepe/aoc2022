<?php

namespace App\Aoc\Day09;

use Illuminate\Support\Collection;

class KnotCollection extends Collection
{
    public function addKnot(Knot $knot): void
    {
        if ($this->isNotEmpty()) {
            $knot->follows($this->last());
        }
        $this->add($knot);
    }
}
