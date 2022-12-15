<?php

namespace Tests\Unit\Aoc\Day12;

use App\Aoc\Day12\Map;
use App\Aoc\Day12\Seeker;
use PHPUnit\Framework\TestCase;

class SeekerTest extends TestCase
{
    public function testSeeksEnd(): void
    {
        $map = $this->makeMap();
        $seeker = new Seeker($map);

        $seeker->seekEnd();

        print $map->route();
    }

    private function makeMap(): Map
    {
        $data = [
            'Sabqponm',
            'abcryxxl',
            'accszExk',
            'acctuvwj',
            'abdefghi',
        ];

        $map = new Map();

        foreach ($data as $line) {
            $map->makeRow($line);
        }

        return $map;
    }
}
