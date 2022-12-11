<?php

namespace App\Aoc\Day10;

class Register
{
    private int $value = 1;

    public function value(): int
    {
        return $this->value;
    }

    public function add(int $value): void
    {
        $this->value += $value;
    }
}
