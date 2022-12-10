<?php

namespace Tests\Unit\Aoc\Day09;

use App\Aoc\Day09\RopeBridgeModeler;
use PHPUnit\Framework\TestCase;

class RopeBridgeModelerTest extends TestCase
{
    public function testStartsWithExpectedCurrentMap(): void
    {
        $bridge = new RopeBridgeModeler(new \ArrayIterator([]));

        $this->assertEquals("H\n", $bridge->map());
    }

    public function testStartsWithExpectedCurrentVisited(): void
    {
        $bridge = new RopeBridgeModeler(new \ArrayIterator([]));

        $this->assertEquals("s\n", $bridge->visited());
    }
}
