<?php

namespace App\Aoc\Day03;

class RucksackGroup
{
    public const MAX_RUCKSACKS = 3;

    private array $rucksacks = [];

    /**
     * @throws \Exception
     */
    public function addRucksack(Rucksack $rucksack): void
    {
        if ($this->isFull()) {
            throw new \Exception('Rucksack group is full');
        }

        $this->rucksacks[] = $rucksack;
    }

    public function isFull(): bool
    {
        return count($this->rucksacks) === self::MAX_RUCKSACKS;
    }

    public function getBadge(): string
    {
        $badges = array_values(array_unique(array_intersect(
            ...array_reduce($this->rucksacks, function (array $contents, Rucksack $rucksack) {
                $contents[] = $rucksack->contents();
                return $contents;
            }, [])
        )));

        return $badges[0];
    }
}
