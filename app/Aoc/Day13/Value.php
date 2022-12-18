<?php

namespace App\Aoc\Day13;

interface Value
{
    public function isInteger(): bool;

    public function isArray(): bool;

    public function asArray(): array;
}
