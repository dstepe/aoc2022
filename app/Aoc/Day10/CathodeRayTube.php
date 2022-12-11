<?php

namespace App\Aoc\Day10;

class CathodeRayTube
{
    private \Iterator $input;

    private Register $register;

    private Clock $clock;
    private Cpu $cpu;
    private Display $display;

    private SignalProcessor $signalProcessor;

    private int $signalStrength = 0;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->clock = new Clock();

        $this->register = new Register();

        $this->display = new Display($this->register);

        $this->clock->addListener($this->display);

        $this->cpu = new Cpu($this->register);

        $this->signalProcessor = new SignalProcessor($this->cpu);

        $this->clock->addListener($this->cpu);
    }

    public function processSignals(): void
    {
        $this->cpu->monitor(function (Cpu $cpu) {
            $this->sampleSignal($cpu);
        });

        foreach ($this->input as $signal) {
            $this->signalProcessor->process($signal);
            $this->clock->tick();
        }

        while ($this->cpu->hasPendingInstructions()) {
            $this->clock->tick();
        }
    }

    public function registerValue(): int
    {
        return $this->register->value();
    }

    public function signalStrength(): int
    {
        return $this->signalStrength;
    }

    public function display(): string
    {
        return $this->display->display();
    }

    private function sampleSignal(Cpu $cpu): void
    {
        if ($this->getSample($cpu->ticks())) {
//            printf("tick %s value %s signal %s\n", $cpu->ticks(), $this->register->value(), $cpu->ticks() * $this->register->value());
            $this->signalStrength += ($cpu->ticks() * $this->register->value());
        }
    }

    private function getSample(int $ticks): bool
    {
        if ($ticks === 20) {
            return true;
        }

        if (($ticks - 20) % 40 === 0) {
            return true;
        }

        return false;
    }
}
