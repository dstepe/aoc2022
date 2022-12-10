<?php

namespace App\Aoc\Day03;

class RucksackReorganization
{
    private \Iterator $input;

    private int $cumulativePriority = 0;

    private RucksackGroup $currentGroup;
    private array $rucksackGroups = [];

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
        $this->currentGroup = new RucksackGroup();
        $this->rucksackGroups[] = $this->currentGroup;
    }

    public function searchRucksacks(): void
    {
        foreach ($this->input as $contents) {
            $this->prioritize($contents);
        }
    }

    public function totalPriority(): int
    {
        return $this->cumulativePriority;
    }

    public function totalBadgePriority(): int
    {
        return array_reduce($this->rucksackGroups, function (int $priority, RucksackGroup $group) {
            $priority += $this->getPriorityForItem($group->getBadge());
            return $priority;
        }, 0);
    }

    private function prioritize(string $contents)
    {
        $rucksack = new Rucksack($contents);

        $common = $rucksack->commonItems();

        foreach ($common as $item) {
            $this->cumulativePriority += $this->getPriorityForItem($item);
        }

        $this->groupRucksack($rucksack);
    }

    private function getPriorityForItem(string $item): int
    {
        $ord = ord($item);

        if ($ord > 96) {
            return $ord - 96;
        }

        return $ord - 64 + 26;
    }

    private function groupRucksack(Rucksack $rucksack): void
    {
        if ($this->currentGroup->isFull()) {
            $this->currentGroup = new RucksackGroup();
            $this->rucksackGroups[] = $this->currentGroup;
        }

        $this->currentGroup->addRucksack($rucksack);
    }
}
