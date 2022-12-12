<?php

namespace App\Aoc\Day11;


class Test
{
    private string $spec;
    private Actions $actions;
    private string $operation;
    private int $value;

    private function __construct(string $spec, Actions $actions)
    {
        $this->spec = $spec;
        $this->actions = $actions;

        $this->parseSpec();
    }

    public static function fromNote(string $note, Actions $actions): self
    {
        $spec = substr($note, strpos($note, ': ') + 2);

        return new self($spec, $actions);
    }

    public function spec(): string
    {
        return $this->spec;
    }

    public function test(Item $item): Action
    {
        $result = $this->runTest($item);

        return $this->actions->getAction($result);
    }

    private function runTest(Item $item): bool
    {
        if ($this->operation === 'division') {
            return $item->worryLevel() % $this->value === 0;
        }

        throw new \InvalidArgumentException(sprintf('Unsupported operation: %s', $this->operation));
    }

    private function parseSpec(): void
    {
        if (preg_match('/divisible by (\d+)/', $this->spec, $matches)) {
            $this->operation = 'division';
            $this->value = $matches[1];
            return;
        }

        throw new \InvalidArgumentException(sprintf('Unable to determine operation for: %s', $this->spec));
    }
}
