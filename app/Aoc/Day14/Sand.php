<?php

namespace App\Aoc\Day14;

class Sand
{
    private CaveMap $caveMap;

    private bool $falling = true;

    private Coordinates $current;

    public function __construct(CaveMap $caveMap)
    {
        $this->caveMap = $caveMap;

        $this->current = $caveMap->sandSource();
    }

    public function isFalling(): bool
    {
        return $this->falling;
    }

    /**
     * @return void
     * @throws FellToAbyssException|PluggedHoleException
     */
    public function fall(): void
    {
        $fallTo = $this->next();

        if ($fallTo === null) {
            $this->falling = false;
            $last = $this->caveMap->findPoint($this->current);
            $last->makeSand();

            if ($last->coordinates()->pair() === $this->caveMap->sandSource()->pair()) {
                throw new PluggedHoleException();
            }

            return;
        }

        $this->current = $fallTo->coordinates();
    }

    /**
     * @return Point|null
     * @throws FellToAbyssException
     */
    private function next(): ?Point
    {
        $candidate = $this->caveMap->findPoint(Coordinates::fromInts($this->current->x(), $this->current->y() + 1));

        if ($candidate->canHoldSand()) {
            return $candidate;
        }

        $candidate = $this->caveMap->findPoint(Coordinates::fromInts($this->current->x() - 1, $this->current->y() + 1));

        if ($candidate->canHoldSand()) {
            return $candidate;
        }

        $candidate = $this->caveMap->findPoint(Coordinates::fromInts($this->current->x() + 1, $this->current->y() + 1));

        if ($candidate->canHoldSand()) {
            return $candidate;
        }

        return null;
    }
}
