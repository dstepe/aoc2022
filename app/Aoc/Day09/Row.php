<?php

namespace App\Aoc\Day09;

use Illuminate\Support\Collection;

class Row extends Collection
{
    public function occupantMap(): string
    {
        return $this->reduce(function (string $c, Position $position) {
            $c .= $position->occupantMarker();
            return $c;
        }, '');
    }

    public function visitedMap(): string
    {
        return $this->reduce(function (string $c, Position $position) {
            $c .= $position->visitedMarker();
            return $c;
        }, '');
    }

    public function visitedCount(): int
    {
        return $this->reduce(function (int $c, Position $position) {
            if ($position->wasVisited()) {
                $c++;
            }
            return $c;
        }, 0);
    }
}
