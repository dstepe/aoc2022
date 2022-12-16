<?php

namespace App\Aoc\Day12;

class HillClimb
{
    private \Iterator $input;
    private Map $map;
    private Seeker $seeker;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
    }

    public function seekRoutes(): void
    {
        $this->map = new Map();

        foreach ($this->input as $line) {
            $this->map->makeRow($line);
        }

        $this->seeker = new Seeker($this->map);
        $this->seeker->seekRoutes();
    }

    public function shortestRoute(): int
    {
        return $this->seeker->shortestRoute();
    }
}
