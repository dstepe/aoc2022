<?php

namespace Tests\Unit\Aoc\Day15;

use App\Aoc\Day15\SensorFactory;
use PHPUnit\Framework\TestCase;

class SensorFactoryTest extends TestCase
{
    public function testMakesSensorFromLine(): void
    {
        $factory = new SensorFactory();

        $line = 'Sensor at x=2, y=18: closest beacon is at x=-2, y=15';

        $sensor = $factory->fromLine($line);

        $this->assertEquals(2, $sensor->x());
        $this->assertEquals(18, $sensor->y());

        $beacon = $sensor->beacon();

        $this->assertEquals(-2, $beacon->x());
        $this->assertEquals(15, $beacon->y());
    }
}
