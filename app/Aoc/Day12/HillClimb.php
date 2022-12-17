<?php

namespace App\Aoc\Day12;

use Illuminate\Console\OutputStyle;

class HillClimb
{
    private \Iterator $input;
    private OutputStyle $output;

    private Map $map;
    private Seeker $seeker;

    public function __construct(\Iterator $input, OutputStyle $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    public function seekRoutes(): void
    {
        $this->map = new Map();

        foreach ($this->input as $line) {
            $this->map->makeRow($line);
        }

        $this->seeker = new Seeker($this->map, $this->output);
        try {
            $this->seeker->seekRoutes('a');
        } catch (\Exception $e) {
            print "Could not find end on map\n";
            exit(1);
        }

        print $this->map->route();
    }

    public function shortestDistance(): int
    {
        return $this->seeker->shortestRoute()->count();
    }
}
