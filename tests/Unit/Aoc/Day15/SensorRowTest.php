<?php

namespace Tests\Unit\Aoc\Day15;

use App\Aoc\Day15\Beacon;
use App\Aoc\Day15\Point;
use App\Aoc\Day15\Sensor;
use App\Aoc\Day15\SensorRow;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class SensorRowTest extends TestCase
{
    public function testCollectsRangesFromSensors(): void
    {
        $sensor = new Sensor(new Point( 8, 7), new Beacon(new Point(2, 10)));

        $row = new SensorRow(5, new Collection());

        $row->checkSensor($sensor);

        $this->assertCount(1, $row->ranges());
    }

    /**
     * @dataProvider excludedPointsChecks
     */
    public function testDeterminesExcludedPointsForRow(int $rowNum, int $expected): void
    {
        $sensor = new Sensor(new Point( 8, 7), new Beacon(new Point(2, 10)));

        $row = new SensorRow($rowNum, new Collection());

        $row->checkSensor($sensor);

        $this->assertCount($expected, $row->excluded());
    }

    public function excludedPointsChecks(): array
    {
        return [
            'row -2' => [-2, 1],
            'row 8' => [8, 17],
            'row 16' => [16, 1],
        ];
    }
}
