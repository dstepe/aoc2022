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

        /** @var Occupant $occupant */
        $occupant = $this->sort(function (Occupant $a, Occupant $b) {
            if ($a->order() === $b->order()) {
                return 0;
            }

            return ($a->order() < $b->order()) ? -1 : 1;
        })->first();

        return $occupant->marker();
    }

    public function remove(Occupant $occupant): void
    {
        $this->items = array_filter($this->items, function (Occupant $inCollection) use ($occupant) {
            if ($inCollection === $occupant) {
                return false;
            }

            return true;
        });
    }
}
