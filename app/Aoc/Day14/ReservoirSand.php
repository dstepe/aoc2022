<?php

namespace App\Aoc\Day14;

use App\Aoc\Day13\Packet;
use App\Aoc\Day13\PacketProcessor;

class ReservoirSand
{
    private \Iterator $input;

    private Scanner $scanner;

    private Cave $cave;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->scanner = new Scanner();
    }

    public function scanStructure(): void
    {
        foreach ($this->input as $line) {
            $this->scanner->processRockPath($line);
        }

        $this->cave = new Cave($this->scanner->rockPaths());
    }

    public function dropSand(): void
    {
        while ($this->cave->isNotFull()) {
            $this->cave->dropSand();
        }
    }

    public function map(): string
    {
        return $this->cave->map();
    }

    public function capacity():int
    {
        return $this->cave->droppedSand();
    }
}
