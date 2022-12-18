<?php

namespace App\Aoc\Day13;

class DistressSignal
{
    private \Iterator $input;
    private PacketProcessor $processor;
    private PacketListener $listener;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->listener = new PacketListener();
        $this->processor = new PacketProcessor($this->listener);
    }

    public function processSignals(): void
    {
        foreach ($this->input as $line) {
            $this->processor->process(Packet::fromLine($line));
        }
    }

    public function correctPacketIndicator(): int
    {
        return array_sum($this->listener->rightIndices());
    }
}
