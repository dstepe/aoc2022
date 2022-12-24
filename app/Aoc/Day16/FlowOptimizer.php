<?php

namespace App\Aoc\Day16;

class FlowOptimizer
{
    private \Iterator $input;
    private Valves $valves;
    private PressureMonitor $pressureMonitor;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->valves = new Valves();
    }

    public function mapTunnels(): void
    {
        foreach ($this->input as $line) {
            $this->valves->makeValveFromDescription($line);
        }
    }

    public function optimizeFlow(): void
    {
        $this->pressureMonitor = new PressureMonitor($this->valves);
        $clock = new Clock();
        $clock->add($this->pressureMonitor);
        $clock->add(new Navigator($this->valves));

        $clock->run();
    }

    public function releasedPressure(): int
    {
        return $this->pressureMonitor->releasedPressure();
    }
}
