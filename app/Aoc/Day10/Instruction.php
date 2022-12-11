<?php

namespace App\Aoc\Day10;

abstract class Instruction
{
    protected string $instruction;

    protected array $arguments = [];

    protected Register $register;

    protected array $steps = [];

    protected int $nextStep = 0;

    protected bool $complete = false;

    public function instruction(): string
    {
        return $this->instruction;
    }

    public function arguments(): array
    {
        return $this->arguments;
    }

    public function modifyRegister(Register $register): void
    {
        $this->register = $register;
    }

    public function tick(): void
    {
        $step = $this->steps[$this->nextStep];
        $this->$step();
        $this->nextStep++;

        $this->complete = $this->nextStep >= count($this->steps);
    }

    public function isComplete(): bool
    {
        return $this->complete;
    }

    protected function noop(): void
    {

    }
}
