<?php

namespace App\Aoc\Day13;

class PacketProcessor
{
    private PacketListener $packetListener;
    private PacketComparison $comparison;

    private array $buffer = [];

    public function __construct(PacketListener $listener, PacketComparison $comparison = null)
    {
        $this->packetListener = $listener;
        $this->comparison = $comparison ?? new PacketComparison();
    }

    public function process(Packet $packet): void
    {
        if ($packet->isNull()) {
            return;
        }

        $this->buffer[] = $packet;

        if (count($this->buffer) < 2) {
            return;
        }

        $this->compareBufferedPackets();
    }

    private function compareBufferedPackets(): void
    {
        $ordered = $this->comparison->packetsAreInOrder(...$this->buffer);

        if ($ordered) {
            $this->packetListener->rightOrder();
        } else {
            $this->packetListener->wrongOrder();
        }

        $this->buffer = [];
    }
}
