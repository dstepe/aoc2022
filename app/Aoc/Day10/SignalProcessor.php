<?php

namespace App\Aoc\Day10;

class SignalProcessor
{
    private Cpu $cpu;

    public function __construct(Cpu $cpu)
    {
        $this->cpu = $cpu;
    }

    public function process(string $signal): void
    {
        $this->cpu->execute($this->parseSignal($signal));
    }

    private function parseSignal(string $signal): Instruction
    {
        if ($signal === 'noop') {
            return new NoopInstruction();
        }

        if (strpos($signal, 'addx') !== 0) {
            throw new \InvalidArgumentException(sprintf('Invalid signal: %s', $signal));
        }

        $argument = (int) str_replace('addx ', '', $signal);

        return new AddxInstruction($argument);
    }
}
