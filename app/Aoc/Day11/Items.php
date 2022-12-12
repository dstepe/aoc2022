<?php

namespace App\Aoc\Day11;

use Illuminate\Support\Collection;

class Items extends Collection
{
    public static function fromNote(string $note): self
    {
        $itemList = explode(', ', substr($note, strpos($note, ': ') + 2));

        $items = new self;

        foreach ($itemList as $worryLevel) {
            $items->add(new Item((int) $worryLevel));
        }

        return $items;
    }

    public function list(): string
    {
        return $this->map(function (Item $item) {
            return $item->worryLevel();
        })->join(', ');
    }
}
