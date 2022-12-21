<?php

namespace App\Aoc\Day15;

class SensorFactory
{
    public function fromLine(string $line): Sensor
    {
        if (!preg_match('/Sensor at x=([0-9-]+), y=([0-9-]+): closest beacon is at x=([0-9-]+), y=([0-9-]+)/', $line, $parts)) {
            throw new \InvalidArgumentException('Cannot parse line ' . $line);
        }

        return new Sensor(new Point($parts[1], $parts[2]), new Beacon(new Point($parts[3], $parts[4])));
    }
}
