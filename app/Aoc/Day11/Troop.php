<?php

namespace App\Aoc\Day11;

use Illuminate\Support\Collection;

class Troop extends Collection
{
    public function addMonkeyFromNotes(array $notes): void
    {
        $this->add(Monkey::fromNotes($notes)->memberOf($this));
    }

    public function getMonkey(int $number): Monkey
    {
        return $this->get($number);
    }

    public function list(): string
    {
        return $this->reduce(function (string $c, Monkey $monkey) {
            return $c . $monkey->label() . ': ' . $monkey->items()->list() . "\n";
        }, '');
    }

    public function inspectCounts(): string
    {
        return $this->reduce(function (string $c, Monkey $monkey) {
            return $c . sprintf('%s inspected items %s times.', $monkey->label(), $monkey->inspected()) . "\n";
        }, '');
    }

    public function monkeyBusinessLevel(): int
    {
        $inspected = $this->map(function (Monkey $monkey) {
            return $monkey->inspected();
        })->sortDesc()->take(2)->toArray();

        return array_product($inspected);
    }

    public function executeRound(): void
    {
        $this->each(function (Monkey $monkey) {
            $monkey->executeTurn();
        });
    }
}
