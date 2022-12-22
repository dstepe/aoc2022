<?php

namespace Tests\Unit\Aoc\Day15;

use App\Aoc\Day15\Beacon;
use App\Aoc\Day15\Point;
use App\Aoc\Day15\Range;
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

        $this->assertEquals($expected, $row->excluded());
    }

    public function excludedPointsChecks(): array
    {
        return [
            'row -2' => [-2, 1],
            'row 8' => [8, 17],
            'row 16' => [16, 1],
        ];
    }

    public function testMergesRangesFromSensorsForRowBeingChecked(): void
    {
        $sensor1 = new Sensor(new Point( 8, 7), new Beacon(new Point(2, 10)));
        $sensor2 = new Sensor(new Point( 10, 11), new Beacon(new Point(15, 18)));
        $sensor3 = new Sensor(new Point( 37, 8), new Beacon(new Point(41, 10)));

        $row = new SensorRow(8, new Collection());

        $row->checkSensor($sensor1);
        $row->checkSensor($sensor2);
        $row->checkSensor($sensor3);

        $row->mergedRanges()->each(function (Range $range) {
            print "Final range " . $range->label() . "\n";
        });
        $this->assertEquals(2, $row->mergedRanges()->count());
    }

    public function testCreatedCoverageFromComplexSensors(): void
    {
        $row = new SensorRow(10, new Collection());

        foreach ($this->sensor() as $sensor) {
            $row->checkSensor($sensor);
        }

        $row->mergedRanges()->each(function (Range $range) {
            printf("Covers %s\n", $range->label());
        });

        $this->assertEquals(26, $row->excluded());
    }

    private function sensor(): array
    {
        return [
            new Sensor(new Point(2, 18), new Beacon(new Point(-2, 15))),
            new Sensor(new Point(9, 16), new Beacon(new Point(10, 16))),
            new Sensor(new Point(13, 2), new Beacon(new Point(15, 3))),
            new Sensor(new Point(12, 14), new Beacon(new Point(10, 16))),
            new Sensor(new Point(10, 20), new Beacon(new Point(10, 16))),
            new Sensor(new Point(14, 17), new Beacon(new Point(10, 16))),
            new Sensor(new Point(8, 7), new Beacon(new Point(2, 10))),
            new Sensor(new Point(2, 0), new Beacon(new Point(2, 10))),
            new Sensor(new Point(0, 11), new Beacon(new Point(2, 10))),
            new Sensor(new Point(20, 14), new Beacon(new Point(25, 17))),
            new Sensor(new Point(17, 20), new Beacon(new Point(21, 22))),
            new Sensor(new Point(16, 7), new Beacon(new Point(15, 3))),
            new Sensor(new Point(14, 3), new Beacon(new Point(15, 3))),
            new Sensor(new Point(20, 1), new Beacon(new Point(15, 3))),
        ];
    }
}
