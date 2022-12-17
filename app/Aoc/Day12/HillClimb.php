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

        printf("Seeking from %s to %s on map size %s\n", $this->map->start(), $this->map->end(), $this->map->size());
        $this->seeker = new Seeker($this->map);
        try {
            $this->seeker->seekRoutes();
        } catch (\Exception $e) {
            print "Could not find end on map\n";
        }

        print $this->map->route();
    }

    public function shortestDistance(): int
    {
        return $this->seeker->shortestRoute()->count();
    }
}
