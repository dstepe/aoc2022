<?php

namespace App\Aoc\Day13;

class PacketListener
{
    private int $indexCount = 0;

    private array $rightIndices = [];
    private array $wrongIndices = [];

    public function rightOrder(): void
    {
        $this->indexCount++;
        $this->rightIndices[] = $this->indexCount;
    }

    public function wrongOrder(): void
    {
        $this->indexCount++;
        $this->wrongIndices[] = $this->indexCount;
    }

    public function rightIndices(): array
    {
        return $this->rightIndices;
    }
}
