<?php

namespace App\Aoc\Day05;

class SupplyStack
{
    private array $crates = [];

    private int $moveCount = 0;
    private int $mode = SupplyStackRearrangement::SINGLE_MODE;

    public function move(int $count, int $mode = SupplyStackRearrangement::SINGLE_MODE): self
    {
        $this->moveCount = $count;
        $this->mode = $mode;
        return $this;
    }

    public function toStack(SupplyStack $stack): void
    {
        if ($this->mode === SupplyStackRearrangement::SINGLE_MODE) {
            for ($i = 0; $i < $this->moveCount; $i++) {
                $stack->pushCrate($this->pullCrate());
            }
        } else {
            $holder = [];
            for ($i = 0; $i < $this->moveCount; $i++) {
                array_unshift($holder, $this->pullCrate());
            }

            foreach ($holder as $crate) {
                $stack->pushCrate($crate);
            }
        }

        $this->moveCount = 0;
    }

    public function pushCrate(SupplyCrate $crate): void
    {
        $this->crates[] = $crate;
    }

    public function pullCrate(): SupplyCrate
    {
        return array_pop($this->crates);
    }

    public function count(): int
    {
        return count($this->crates);
    }

    public function topCrate(): SupplyCrate
    {
        return end($this->crates);
    }
}
