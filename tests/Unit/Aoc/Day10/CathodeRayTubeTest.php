<?php

namespace Tests\Unit\Aoc\Day10;

use App\Aoc\Day10\CathodeRayTube;
use PHPUnit\Framework\TestCase;

class CathodeRayTubeTest extends TestCase
{
    public function testProcessesSignals(): void
    {
        $crt = new CathodeRayTube(new \ArrayIterator([
            'noop',
            'addx 3',
            'addx -5',
        ]));

        $crt->processSignals();

        $this->assertEquals(-1, $crt->registerValue());
    }

    public function testProcessesFirstTwentySignals(): void
    {
        $crt = new CathodeRayTube($this->signalsShort());

        $crt->processSignals();

        $this->assertEquals(420, $crt->signalStrength());
    }

    public function testProcessesComplexSignals(): void
    {
        $crt = new CathodeRayTube($this->signals());

        $crt->processSignals();

        $this->assertEquals(13140, $crt->signalStrength());
    }

    public function testDisplaysResults(): void
    {
        $crt = new CathodeRayTube($this->signalsShort());

        $crt->processSignals();

        print $crt->display();
        $this->assertEquals(420, $crt->signalStrength());
    }

    public function testDisplaysAllResults(): void
    {
        $crt = new CathodeRayTube($this->signals());

        $crt->processSignals();

        print $crt->display();
//        $this->assertEquals(420, $crt->signalStrength());
    }

    private function signalsShort(): \ArrayIterator
    {
        return new \ArrayIterator([
            "addx 15",
            "addx -11",
            "addx 6",
            "addx -3",
            "addx 5",
            "addx -1",
            "addx -8",
            "addx 13",
            "addx 4",
            "noop",
            "addx -1",
        ]);
    }

    private function signals(): \ArrayIterator
    {
        return new \ArrayIterator([
            "addx 15",
            "addx -11",
            "addx 6",
            "addx -3",
            "addx 5",
            "addx -1",
            "addx -8",
            "addx 13",
            "addx 4",
            "noop",
            "addx -1",
            "addx 5",
            "addx -1",
            "addx 5",
            "addx -1",
            "addx 5",
            "addx -1",
            "addx 5",
            "addx -1",
            "addx -35",
            "addx 1",
            "addx 24",
            "addx -19",
            "addx 1",
            "addx 16",
            "addx -11",
            "noop",
            "noop",
            "addx 21",
            "addx -15",
            "noop",
            "noop",
            "addx -3",
            "addx 9",
            "addx 1",
            "addx -3",
            "addx 8",
            "addx 1",
            "addx 5",
            "noop",
            "noop",
            "noop",
            "noop",
            "noop",
            "addx -36",
            "noop",
            "addx 1",
            "addx 7",
            "noop",
            "noop",
            "noop",
            "addx 2",
            "addx 6",
            "noop",
            "noop",
            "noop",
            "noop",
            "noop",
            "addx 1",
            "noop",
            "noop",
            "addx 7",
            "addx 1",
            "noop",
            "addx -13",
            "addx 13",
            "addx 7",
            "noop",
            "addx 1",
            "addx -33",
            "noop",
            "noop",
            "noop",
            "addx 2",
            "noop",
            "noop",
            "noop",
            "addx 8",
            "noop",
            "addx -1",
            "addx 2",
            "addx 1",
            "noop",
            "addx 17",
            "addx -9",
            "addx 1",
            "addx 1",
            "addx -3",
            "addx 11",
            "noop",
            "noop",
            "addx 1",
            "noop",
            "addx 1",
            "noop",
            "noop",
            "addx -13",
            "addx -19",
            "addx 1",
            "addx 3",
            "addx 26",
            "addx -30",
            "addx 12",
            "addx -1",
            "addx 3",
            "addx 1",
            "noop",
            "noop",
            "noop",
            "addx -9",
            "addx 18",
            "addx 1",
            "addx 2",
            "noop",
            "noop",
            "addx 9",
            "noop",
            "noop",
            "noop",
            "addx -1",
            "addx 2",
            "addx -37",
            "addx 1",
            "addx 3",
            "noop",
            "addx 15",
            "addx -21",
            "addx 22",
            "addx -6",
            "addx 1",
            "noop",
            "addx 2",
            "addx 1",
            "noop",
            "addx -10",
            "noop",
            "noop",
            "addx 20",
            "addx 1",
            "addx 2",
            "addx 2",
            "addx -6",
            "addx -11",
            "noop",
            "noop",
            "noop",
        ]);
    }
}
