<?php

namespace App\Aoc\Day13;

class ValueInteger implements Value
{

    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function isInteger(): bool
    {
        return true;
    }

    public function isArray(): bool
    {
        return false;
    }

    public function asArray(): array
    {
        return [$this->value];
    }
}
