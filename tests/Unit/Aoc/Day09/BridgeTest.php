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

        $this->assertEquals("1H\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionUp(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 1);

        $this->assertEquals("H\n1\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionRightTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 2);

        $this->assertEquals("21H\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionUpTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 2);

        $this->assertEquals("H\n1\n2\n", $bridge->occupantMap());
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

        $this->assertEquals("3H1.\n", $bridge->occupantMap());
    }

    public function testMovesHeadPositionDownTwo(): void
    {
        $bridge = new Bridge();

        $bridge->move('U', 3);
        $bridge->move('D', 2);

        $this->assertEquals(".\n1\nH\n3\n", $bridge->occupantMap());
    }

    public function testRunsSeriesOfMovesForOccupantMap(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 5);
        $bridge->move('U', 8);
        $bridge->move('L', 8);
        $bridge->move('D', 3);
        $bridge->move('R', 17);
        $bridge->move('D', 10);
        $bridge->move('L', 25);
        $bridge->move('U', 20);

        print $bridge->occupantMap();
        $expected =
            "H.........................\n" .
            "1.........................\n" .
            "2.........................\n" .
            "3.........................\n" .
            "4.........................\n" .
            "5.........................\n" .
            "6.........................\n" .
            "7.........................\n" .
            "8.........................\n" .
            "9.........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "...........s..............\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n";

        $this->assertEquals($expected, $bridge->occupantMap());
    }

    public function testRunsSeriesOfMovesForVisitedMap(): void
    {
        $bridge = new Bridge();

        $bridge->move('R', 5);
        $bridge->move('U', 8);
        $bridge->move('L', 8);
        $bridge->move('D', 3);
        $bridge->move('R', 17);
        $bridge->move('D', 10);
        $bridge->move('L', 25);
        $bridge->move('U', 20);

        print $bridge->visitedMap();
        $expected =
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "..........................\n" .
            "#.........................\n" .
            "#.............###.........\n" .
            "#............#...#........\n" .
            ".#..........#.....#.......\n" .
            "..#..........#.....#......\n" .
            "...#........#.......#.....\n" .
            "....#......s.........#....\n" .
            ".....#..............#.....\n" .
            "......#............#......\n" .
            ".......#..........#.......\n" .
            "........#........#........\n" .
            ".........########.........\n";

        $this->assertEquals($expected, $bridge->visitedMap());
        $this->assertEquals(36, $bridge->visitedCount());
    }

    public function testHandlesAddingRowsDown(): void
    {
        $bridge = new Bridge();

        $bridge->move('D', 3);

        print $bridge->occupantMap();
        $expected = "3\n" .
                    "2\n" .
                    "1\n" .
                    "H\n";

        $this->assertEquals($expected, $bridge->occupantMap());
    }

    public function testHandlesAddingRowsLeft(): void
    {
        $bridge = new Bridge();

        $bridge->move('L', 3);

        print $bridge->occupantMap();
        $expected = "H123\n";

        $this->assertEquals($expected, $bridge->occupantMap());
    }
}
