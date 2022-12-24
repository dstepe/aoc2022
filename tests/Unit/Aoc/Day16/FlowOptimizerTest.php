<?php

namespace Tests\Unit\Aoc\Day16;

use App\Aoc\Day16\FlowOptimizer;
use PHPUnit\Framework\TestCase;

class FlowOptimizerTest extends TestCase
{
    public function testOptimizesFlow(): void
    {
        $optimizer = new FlowOptimizer(new \ArrayIterator($this->valves()));

        $optimizer->mapTunnels();
        $optimizer->optimizeFlow();

        $this->assertEquals(1651, $optimizer->releasedPressure());
    }

    private function valves(): array
    {
        return [
            'Valve AA has flow rate=0; tunnels lead to valves DD, II, BB',
            'Valve BB has flow rate=13; tunnels lead to valves CC, AA',
            'Valve CC has flow rate=2; tunnels lead to valves DD, BB',
            'Valve DD has flow rate=20; tunnels lead to valves CC, AA, EE',
            'Valve EE has flow rate=3; tunnels lead to valves FF, DD',
            'Valve FF has flow rate=0; tunnels lead to valves EE, GG',
            'Valve GG has flow rate=0; tunnels lead to valves FF, HH',
            'Valve HH has flow rate=22; tunnel leads to valve GG',
            'Valve II has flow rate=0; tunnels lead to valves AA, JJ',
            'Valve JJ has flow rate=21; tunnel leads to valve II',
        ];
    }
}
