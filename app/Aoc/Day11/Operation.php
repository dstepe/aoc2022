<?php

namespace App\Aoc\Day11;

class Operation
{
    private string $spec;

    private function __construct(string $spec)
    {
        $this->spec = $spec;
    }

    public static function fromNote(string $note): self
    {
        $spec = substr($note, strpos($note, ': ') + 2);

        return new self(str_replace('new = ', '', $spec));
    }

    public function spec(): string
    {
        return $this->spec;
    }

    public function evaluate(Item $item): int
    {
        $level = eval($this->makeExpression($item->worryLevel()));

        return $this->applyRelief($level);
    }

    private function makeExpression(int $level): string
    {
        return 'return ' . str_replace('old', $level, $this->spec) . ';';
    }

    private function applyRelief(float $level): int
    {
        return (int) floor($level / 3);
    }
}
