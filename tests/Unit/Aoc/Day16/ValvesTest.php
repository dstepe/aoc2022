<?php

namespace Tests\Unit\Aoc\Day16;

use App\Aoc\Day16\Valves;
use PHPUnit\Framework\TestCase;

class ValvesTest extends TestCase
{
    public function testCreatesValveFromDescription(): void
    {
        $valves = new Valves();

        $valve = $valves->makeValveFromDescription(
            'Valve AA has flow rate=0; tunnels lead to valves DD, II, BB'
        );

        $this->assertEquals('AA', $valve->label());
        $this->assertEquals(0, $valve->flowRate());
        $this->assertTrue($valve->leadsTo('DD'));
        $this->assertTrue($valve->leadsTo('II'));
        $this->assertTrue($valve->leadsTo('BB'));
    }

    public function testCreatesValveFromDescriptionWithOneRow(): void
    {
        $valves = new Valves();

        $valve = $valves->makeValveFromDescription(
            'Valve HH has flow rate=22; tunnel leads to valve GG'
        );

        $this->assertEquals('HH', $valve->label());
        $this->assertEquals(22, $valve->flowRate());
        $this->assertTrue($valve->leadsTo('GG'));
    }

    public function testRemembersNewValve(): void
    {
        $valves = new Valves();

        $valves->makeValveFromDescription(
            'Valve AA has flow rate=0; tunnels lead to valves DD, II, BB'
        );

        $this->assertCount(1, $valves);
    }

    public function testFindsConnectionsForValve(): void
    {
        $valves = new Valves();

        $start = $valves->makeValveFromDescription('Valve AA has flow rate=0; tunnels lead to valves DD, II, BB');
        $valves->makeValveFromDescription('Valve DD has flow rate=20; tunnels lead to valves CC, AA, EE');
        $valves->makeValveFromDescription('Valve II has flow rate=0; tunnels lead to valves AA, JJ');
        $valves->makeValveFromDescription('Valve BB has flow rate=13; tunnels lead to valves CC, AA');

        $connections = $valves->connections($start);

        $this->assertCount(3, $connections);
    }
}
