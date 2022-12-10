<?php

namespace App\Aoc\Day08;

class TreetopView
{
    private \Iterator $input;

    private Forest $forest;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
        $this->forest = new Forest();
    }

    public function makeMap(): void
    {
        foreach ($this->input as $line) {
            $this->forest->addRow($line);
        }
    }

    public function map(): string
    {
        return $this->forest->map();
    }

    public function visible(): int
    {
        return $this->forest->visible();
    }

    public function visibleMap(): string
    {
        return $this->forest->visibleMap();
    }

    public function highestScenicScore(): int
    {
        return $this->forest->highestScenicScore();
    }
}
