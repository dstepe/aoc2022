<?php

namespace App\Aoc\Day11;

class Action
{
    private bool $condition;
    private string $spec;
    private int $monkeyNumber;

    private function __construct(bool $condition, string $spec)
    {
        $this->condition = $condition;
        $this->spec = $spec;
        $this->monkeyNumber = (int) str_replace('throw to monkey ', '', $this->spec);
    }

    public static function fromNote(string $note): self
    {
        [$conditionSpec, $actionSpec] = explode(': ', $note);

        $condition = str_contains($conditionSpec, 'true');

        return new self($condition, $actionSpec);
    }

    public function condition(): bool
    {
        return $this->condition;
    }

    public function spec(): string
    {
        return $this->spec;
    }

    public function targetMonkey(): int
    {
        return $this->monkeyNumber;
    }
}
