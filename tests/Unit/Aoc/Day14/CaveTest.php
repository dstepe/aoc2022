<?php

namespace Tests\Unit\Aoc\Day14;

use App\Aoc\Day14\Cave;
use App\Aoc\Day14\Scanner;
use PHPUnit\Framework\TestCase;

class CaveTest extends TestCase
{
    public function testConstructsCave(): void
    {
        $scanner = new Scanner();

        $scanner->processRockPath('498,4 -> 498,6 -> 496,6');
        $scanner->processRockPath('503,4 -> 502,4 -> 502,9 -> 494,9');

        $cave = new Cave($scanner->rockPaths());

        print $cave->map();
    }

    public function testDropsSandInCave(): void
    {
        $scanner = new Scanner();

        $scanner->processRockPath('498,4 -> 498,6 -> 496,6');
        $scanner->processRockPath('503,4 -> 502,4 -> 502,9 -> 494,9');

        $cave = new Cave($scanner->rockPaths());

        while ($cave->isNotFull()) {
            $cave->dropSand();
        }

        print $cave->map();

        $this->assertEquals(24, $cave->droppedSand());
    }
}
