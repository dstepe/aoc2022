<?php

namespace App\Aoc\Day11;

class Monkey
{
    private int $number;
    private Items $items;
    private Operation $operation;
    private Test $test;
    private ?Troop $troop;

    private int $inspectCount = 0;

    private function __construct(int $number, Items $items, Operation $operation, Test $test, Troop $troop = null)
    {
        $this->number = $number;
        $this->items = $items;
        $this->operation = $operation;
        $this->test = $test;
        $this->troop = $troop;
    }

    public static function fromNotes(array $notes): self
    {
        $number = (int) str_replace(['Monkey ', ':'], '', $notes[0]);
        $items = Items::fromNote($notes[1]);
        $operation = Operation::fromNote($notes[2]);
        $test = Test::fromNote($notes[3], Actions::fromNotes($notes[4], $notes[5]));

        return new self($number, $items, $operation, $test);
    }

    public function memberOf(Troop $troop): self
    {
        return new self($this->number, $this->items, $this->operation, $this->test, $troop);
    }

    public function label(): string
    {
        return sprintf('Monkey %s', $this->number);
    }

    public function items(): Items
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        $this->items->add($item);
    }

    public function executeTurn(): void
    {
        while ($this->items->count() > 0) {
            $item = $this->items->shift();

            $newItem = $this->inspect($item);

            $action = $this->test->test($newItem);

            $targetMonkey = $this->troop->getMonkey($action->targetMonkey());

            $targetMonkey->addItem($newItem);
        }
    }

    public function inspected(): int
    {
        return $this->inspectCount;
    }

    private function inspect(Item $item): Item
    {
        $this->inspectCount++;
        return new Item($this->operation->evaluate($item));
    }
}
