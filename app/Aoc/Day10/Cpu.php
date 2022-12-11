<?php

namespace App\Aoc\Day10;

use Illuminate\Support\Collection;

class Cpu
{
    private Register $register;

    private Collection $stack;

    /** @var callable */
    private $monitor;

    private int $ticks = 0;

    public function __construct(Register $register)
    {
        $this->register = $register;

        $this->stack = new Collection();
    }

    public function monitor(callable $monitor): void
    {
        $this->monitor = $monitor;
    }

    public function execute(Instruction $instruction): void
    {
        $instruction->modifyRegister($this->register);
        $this->stack->add($instruction);
    }

    public function tick(): void
    {
        $this->ticks++;

        $this->broadcast();

        if ($this->stack->isNotEmpty()) {
            /** @var Instruction $instruction */
            $instruction = $this->stack->get(0);

            $instruction->tick();
//            if ($this->ticks < 25) {
//                printf("instruction %s tick %s complete %s register %s\n",
//                    $instruction->instruction(), $this->ticks, $instruction->isComplete(), $this->register->value());
//            }

            $this->stack = $this->stack->reject(function (Instruction $instruction) {
                return $instruction->isComplete();
            })->values();
        }
    }

    public function ticks(): int
    {
        return $this->ticks;
    }

    public function hasPendingInstructions(): bool
    {
        return $this->stack->isNotEmpty();
    }

    private function broadcast(): void
    {
        if (empty($this->monitor)) {
            return;
        }

        $callback = $this->monitor;
        $callback($this);
    }
}
