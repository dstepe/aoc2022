<?php

namespace App\Aoc\Day12;

class Seeker
{
    private Map $map;
    private Position $position;
    private Position $end;
    private int $moveLimit;

    public function __construct(Map $map)
    {
        $this->map = $map;

        $this->initialize();
    }

    public function seekEnd(): void
    {
        $attempt = 0;

        while ($this->position->isNot($this->end) && $attempt < $this->moveLimit) {
            $next = $this->position->findNextPosition();
            $this->position->leaveFor($next);
            $this->position = $next;
            $attempt++;
        }
    }

    private function initialize(): void
    {
        if (empty($this->position)) {
            $this->position = $this->map->start();
        }

        if (empty($this->end)) {
            $this->end = $this->map->end();
        }

        $this->moveLimit = $this->map->size();
    }
}
