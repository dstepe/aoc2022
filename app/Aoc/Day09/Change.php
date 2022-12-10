<?php

namespace App\Aoc\Day09;

class Change
{
    private int $rows;
    private int $columns;

    public function __construct(int $rows, int $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function rows(): int
    {
        return $this->rows;
    }

    public function columns(): int
    {
        return $this->columns;
    }

    public function noChange(): bool
    {
        return $this->rows === 0 &&  $this->columns === 0;
    }
}
