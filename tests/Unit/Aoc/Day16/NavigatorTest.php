<?php

namespace Tests\Unit\Aoc\Day16;

use App\Aoc\Day16\Navigator;
use App\Aoc\Day16\Valves;
use PHPUnit\Framework\TestCase;

class NavigatorTest extends TestCase
{
    private Valves $valves;

    public function setUp(): void
    {
        parent::setUp();

        $this->valves = $this->valves();
    }

    public function testFindsBestRoute(): void
    {
        $start = $this->valves->get('AA');

        $mapper = new Navigator($this->valves);

        $route = $mapper->bestNextMove($start);

        $this->assertEquals('AA, DD', $route->path());
    }

    public function testFindsBestRouteAfterOpeningFirst(): void
    {
        $start = $this->valves->get('DD');
        $start->open();

        $mapper = new Navigator($this->valves);

        $route = $mapper->bestNextMove($start);

        $this->assertEquals('DD, CC, BB', $route->path());
    }

    private function valves(): Valves
    {
        $descriptions =  [
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

        $valves = new Valves();

        foreach ($descriptions as $description) {
            $valves->makeValveFromDescription($description);
        }

        return $valves;
    }
}
