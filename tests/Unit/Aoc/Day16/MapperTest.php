<?php

namespace Tests\Unit\Aoc\Day16;

use App\Aoc\Day16\Mapper;
use App\Aoc\Day16\Valve;
use App\Aoc\Day16\Valves;
use PHPUnit\Framework\TestCase;

class MapperTest extends TestCase
{
    private Valves $valves;

    public function setUp(): void
    {
        parent::setUp();

        $this->valves = $this->valves();
    }

    /**
     * @dataProvider findsRouteChecks
     */
    public function testFindsRouteBetweenValves(string $from, string $to, string $first): void
    {
        $start = $this->valves->get($from);
        $end = $this->valves->get($to);

        $mapper = new Mapper($this->valves);

        $route = $mapper->findRoute($start, $end);

        $route->each(function (Valve $v) {
            printf("valve %s\n", $v->label());
        });

        $this->assertEquals($first, $route->get(1)->label());
    }

    public function findsRouteChecks(): array
    {
        return [
            'AA -> DD' => ['AA', 'DD', 'DD'],
            'DD -> BB' => ['DD', 'BB', 'AA'],
            'BB -> JJ' => ['BB', 'JJ', 'AA'],
            'JJ -> HH' => ['JJ', 'HH', 'II'],
        ];
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
