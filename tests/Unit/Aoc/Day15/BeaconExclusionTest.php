<?php

namespace Tests\Unit\Aoc\Day15;

use App\Aoc\Day15\BeaconExclusion;
use PHPUnit\Framework\TestCase;

class BeaconExclusionTest extends TestCase
{
    public function testFindsExclusionsInRow(): void
    {
        $analyzer = new BeaconExclusion(new \ArrayIterator($this->sensorData()));

        $analyzer->loadBeacons();
        $analyzer->analyzeRow(10);

        $this->assertEquals(26, $analyzer->exclusions());
    }

    public function testFindsTuningFrequencyForUndetectedBeaon(): void
    {
        $analyzer = new BeaconExclusion(new \ArrayIterator($this->sensorData()));

        $analyzer->loadBeacons();

        $this->assertEquals(56000011, $analyzer->undetectedBeaconTuningFrequency(20));
    }

    private function sensorData(): array
    {
        return [
            'Sensor at x=2, y=18: closest beacon is at x=-2, y=15',
            'Sensor at x=9, y=16: closest beacon is at x=10, y=16',
            'Sensor at x=13, y=2: closest beacon is at x=15, y=3',
            'Sensor at x=12, y=14: closest beacon is at x=10, y=16',
            'Sensor at x=10, y=20: closest beacon is at x=10, y=16',
            'Sensor at x=14, y=17: closest beacon is at x=10, y=16',
            'Sensor at x=8, y=7: closest beacon is at x=2, y=10',
            'Sensor at x=2, y=0: closest beacon is at x=2, y=10',
            'Sensor at x=0, y=11: closest beacon is at x=2, y=10',
            'Sensor at x=20, y=14: closest beacon is at x=25, y=17',
            'Sensor at x=17, y=20: closest beacon is at x=21, y=22',
            'Sensor at x=16, y=7: closest beacon is at x=15, y=3',
            'Sensor at x=14, y=3: closest beacon is at x=15, y=3',
            'Sensor at x=20, y=1: closest beacon is at x=15, y=3',
        ];
    }
}
