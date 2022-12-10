<?php

namespace Tests\Unit\Aoc\Day09;

use App\Aoc\Day09\Bridge;
use PHPUnit\Framework\TestCase;

class BridgeTest extends TestCase
{
    public function testStartsWithExpectedOccupantMap(): void
    {
        $bridge = new Bridge();

        $this->assertEquals("H\n", $bridge->occupantMap());
    }

    public function testStartsWithExpectedVisitedMap(): void
    {
        $bridge = new Bridge();

        $this->assertEquals("s\n", $bridge->visitedMap());
    }

    public function testMovesHeadPositionRight(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 1);

        $this->assertEquals("TH\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionUp(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 1);

        $this->assertEquals("H\nT\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionRightTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 2);

        $this->assertEquals("sTH\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionUpTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 2);

        $this->assertEquals("H\nT\ns\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionLeft(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 1);
        $bridge->move('L', 1);

        $this->assertEquals("H.\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionDown(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 1);
        $bridge->move('D', 1);

        $this->assertEquals(".\nH\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionLeftTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 3);
        $bridge->move('L', 2);

        $this->assertEquals("sHT.\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionDownTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 3);
        $bridge->move('D', 2);

        $this->assertEquals(".\nT\nH\ns\n", $bridge->occupantMap());
    }

    public function testRunsSeriesOfMoves(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 4);
        $bridge->move('U', 4);
        $bridge->move('L', 3);
        $bridge->move('D', 1);
        $bridge->move('R', 4);
        $bridge->move('D', 1);
        $bridge->move('L', 5);
        $bridge->move('R', 2);

        print $bridge->occupantMap();
        $expected = "......\n" .
                    "......\n" .
                    ".TH...\n" .
                    "......\n" .
                    "s.....\n";

        $this->assertEquals($expected, $bridge->occupantMap());
    }

    public function testHandlesAddingRowsDown(): void
    {
        $bridge = new Bridge();

        $bridge->move('D', 3);

        print $bridge->occupantMap();
        $expected = "s\n" .
                    ".\n" .
                    "T\n" .
                    "H\n";

        $this->assertEquals($expected, $bridge->occupantMap());
    }

    public function testHandlesAddingRowsLeft(): void
    {
        $bridge = new Bridge();

        $bridge->move('L', 3);

        print $bridge->occupantMap();
        $expected = "HT.s\n";

        $this->assertEquals($expected, $bridge->occupantMap());
    }
}
