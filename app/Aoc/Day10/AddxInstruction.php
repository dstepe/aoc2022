<?php

namespace App\Aoc\Day10;

class AddxInstruction extends Instruction
{
    protected string $instruction = 'addx';

    protected array $steps = ['noop', 'add'];

    public function __construct(int $value)
    {
        $this->arguments[] = $value;
    }

    public function add(): void
    {
        $this->register->add($this->arguments[0]);
    }
}
