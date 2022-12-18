<?php

namespace App\Aoc\Day13;

class DistressSignal
{
    private \Iterator $input;
    private PacketProcessor $processor;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->processor = new PacketProcessor();
    }

    public function processSignals(): void
    {
        foreach ($this->input as $line) {
            $this->processor->addPacket(Packet::fromLine($line));
        }

        $this->processor->orderPackets();
    }

    public function decoderKey(): int
    {
        return $this->processor->decoderKey();
    }
}
