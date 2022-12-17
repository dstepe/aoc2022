<?php

namespace App\Aoc\Day12;

use Illuminate\Support\Collection;

class Row extends Collection
{
    public function mapRow(): string
    {
        return $this->reduce(function (string $c, Position $position) {
            return $c . $position->label();
        }, '');
    }

    public function markers(): string
    {
        return $this->reduce(function (string $c, Position $position) {
            return $c . $position->marker();
        }, '');
    }

    public function findAll(string $label): Collection
    {
        return $this->reduce(function (Collection $c, Position $position) use ($label) {
            if ($position->label() === $label) {
                $c->add($position);
            }
            return $c;
        }, new Collection());
    }
}
