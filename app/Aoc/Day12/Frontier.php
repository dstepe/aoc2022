<?php

namespace App\Aoc\Day12;

use Illuminate\Support\Collection;

class Frontier extends Collection
{
    public function enqueue(Position $position, int $priority): void
    {
        $this->add([
            'position' => $position,
            'priority' => $priority
        ]);

        $this->items = $this->sort(function (array $a, array $b) {
            if ($a['priority'] === $b['priority']) {
                return 0;
            }
            return ($a['priority'] < $b['priority']) ? -1 : 1;
        })->toArray();
    }

    public function dequeue(): Position
    {
        return $this->shift()['position'];
    }
}
