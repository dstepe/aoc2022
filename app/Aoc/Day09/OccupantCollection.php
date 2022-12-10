<?php

namespace App\Aoc\Day09;

use Illuminate\Support\Collection;

class OccupantCollection extends Collection
{
    public const EMPTY_MARKER = '.';

    public function occupantMarker(): string
    {
        if ($this->isEmpty()) {
            return self::EMPTY_MARKER;
        }

        /** @var Knot $occupant */
        $occupant = $this->sort(function (Knot $a, Knot $b) {
            if ($a->order() === $b->order()) {
                return 0;
            }

            return ($a->order() < $b->order()) ? -1 : 1;
        })->first();

        return $occupant->marker();
    }

    public function remove(Knot $occupant): void
    {
        $this->items = array_filter($this->items, function (Knot $inCollection) use ($occupant) {
            if ($inCollection === $occupant) {
                return false;
            }

            return true;
        });
    }
}
