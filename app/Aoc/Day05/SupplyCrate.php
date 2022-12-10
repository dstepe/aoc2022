<?php

namespace App\Aoc\Day05;

class SupplyCrate
{
    private string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function label(): string
    {
        return $this->label;
    }
}
