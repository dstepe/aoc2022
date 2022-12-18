<?php

namespace App\Aoc\Day13;

class ValueArray implements Value
{
    private array $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function isInteger(): bool
    {
        return false;
    }

    public function isArray(): bool
    {
        return true;
    }

    public function asArray(): array
    {
        return $this->values;
    }
}
