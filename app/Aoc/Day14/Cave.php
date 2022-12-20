<?php

namespace App\Aoc\Day14;

use Illuminate\Support\Collection;

class Cave
{
    private CaveMap $caveMap;

    private int $droppedSand = 0;
    private bool $isFull = false;

    public function __construct(RockPaths $rockPaths)
    {
        $this->caveMap = new CaveMap($rockPaths);
    }

    public function dropSand(): void
    {
        $sand = new Sand($this->caveMap);

        while ($sand->isFalling()) {
            try {
                $sand->fall();
            } catch (FellToAbyssException $e) {
                $this->isFull = true;
                return;
            } catch (PluggedHoleException $e) {
                $this->droppedSand++; // count last sand in this case
                $this->isFull = true;
                return;
            }
        }

        $this->droppedSand++;
//        if ($this->droppedSand >= 10000) {
//            $this->isFull = true;
//        }
    }

    public function isFull(): bool
    {
        return $this->isFull;
    }

    public function isNotFull(): bool
    {
        return !$this->isFull();
    }

    public function droppedSand(): int
    {
        return $this->droppedSand;
    }

    public function map(): string
    {
        return $this->caveMap->renderMap();
    }
}
