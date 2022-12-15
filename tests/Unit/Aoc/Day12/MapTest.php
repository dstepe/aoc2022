<?php

namespace Tests\Unit\Aoc\Day12;

use App\Aoc\Day12\Map;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    public function testMakesMapFromData(): void
    {
        $map = new Map();

        foreach ($this->mapData() as $line) {
            $map->makeRow($line);
        }

        $expected = "Sabqponm\n" .
            "abcryxxl\n" .
            "accszExk\n" .
            "acctuvwj\n" .
            "abdefghi\n";

        $this->assertEquals($expected, $map->map());
    }

    public function testFindsStartPosition(): void
    {
        $map = new Map();

        foreach ($this->mapData() as $line) {
            $map->makeRow($line);
        }

        $this->assertEquals(0, $map->start()->row());
        $this->assertEquals(0, $map->start()->column());
    }

    public function testFindsEndPosition(): void
    {
        $map = new Map();

        foreach ($this->mapData() as $line) {
            $map->makeRow($line);
        }

        $this->assertEquals(2, $map->end()->row());
        $this->assertEquals(5, $map->end()->column());
    }

    private function mapData(): array
    {
        return [
            'Sabqponm',
            'abcryxxl',
            'accszExk',
            'acctuvwj',
            'abdefghi',
        ];
    }
}
