<?php

namespace App\Aoc\Day10;

class NoopInstruction extends Instruction
{
    protected string $instruction = 'noop';

    protected array $steps = ['noop'];
}
