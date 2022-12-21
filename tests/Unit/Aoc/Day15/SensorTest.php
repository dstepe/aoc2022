<?php

namespace Tests\Unit\Aoc\Day15;

use App\Aoc\Day15\Beacon;
use App\Aoc\Day15\Point;
use App\Aoc\Day15\Sensor;
use PHPUnit\Framework\TestCase;

class SensorTest extends TestCase
{
    /**
     * @dataProvider coversRowChecks
     */
    public function testCoversRow(int $row, bool $expected): void
    {
        $sensor = new Sensor(8, 7, new Beacon(2, 10));

        $this->assertEquals($expected, $sensor->coversRow($row));
    }

    public function coversRowChecks(): array
    {
        return [
            'covered low' => [6, true],
            'not covered low' => [-3, false],
            'covered high' => [9, true],
            'not covered high' => [22, false],
        ];
    }

    /*
-2 ..........#.................
-1 .........###................
 0 ....S...#####...............
 1 .......#######........S.....
 2 ......#########S............
 3 .....###########SB..........
 4 ....#############...........
 5 ...###############..........
 6 ..#################.........
 7 .#########S#######S#........
 8 ..#################.........
 9 ...###############..........
10 ....B############...........
11 ..S..###########............
12 ......#########.............
13 .......#######..............
14 ........#####.S.......S.....
15 B........###................
16 ..........#SB...............
1
     */
    /**
     * @dataProvider findsCoveredChecks
     */
    public function testFindsCoveredInRow(int $rowNum, int $expected): void
    {
        $sensor = new Sensor(new Point( 8, 7), new Beacon(new Point(2, 10)));

        $range = $sensor->positionsSeenInRow($rowNum);

        $this->assertEquals($expected, $range->span());
    }

    public function findsCoveredChecks(): array
    {
        return [
            'row -2' => [-2, 1],
            'row -1' => [-1, 3],
        ];
    }
}
