<?php

namespace App\Aoc\Day11;

class Operation
{
    private static int $reliefFactor = 3;

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

    public static function reliefFactor(int $reliefFactor): void
    {
        self::$reliefFactor = $reliefFactor;
    }

    public function spec(): string
    {
        return $this->spec;
    }

    public function evaluate(Item $item): int
    {
        $expression = $this->makeExpression($item->worryLevel());

        $level = match ($expression[1]) {
            '*' => $expression[0] * $expression[2],
            '+' => $expression[0] + $expression[2],
            default => throw new \InvalidArgumentException(sprintf('Unsupported expressions: %s', $expression[1])),
        };

        return $this->applyRelief($level);
    }

    private function makeExpression(int $level): array
    {
        return explode(' ', str_replace('old', $level, $this->spec));
    }

    private function applyRelief(float $level): int
    {
        return (int) floor($level / self::$reliefFactor);
    }
}
