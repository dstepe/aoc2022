<?php

namespace App\Aoc\Day03;

class Rucksack
{
    private array $compartments = [];

    public function __construct(string $contents)
    {
        $this->putContentsInCompartments($contents);
    }

    public function compartmentOne(): array
    {
        return $this->compartment(0);
    }

    public function compartmentTwo(): array
    {
        return $this->compartment(1);
    }

    public function commonItems(): array
    {
        return array_values(array_unique(array_intersect(...$this->compartments)));
    }

    public function contents(): array
    {
        return array_merge(...$this->compartments);
    }

    private function compartment(int $number): array
    {
        return $this->compartments[$number];
    }

    private function putContentsInCompartments(string $contents)
    {
        $totalContents = strlen($contents);

        $this->compartments[0] = str_split(substr($contents, 0, $totalContents / 2));
        $this->compartments[1] = str_split(substr($contents, $totalContents / 2));
    }
}
