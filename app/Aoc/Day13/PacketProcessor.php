<?php

namespace App\Aoc\Day13;

class PacketProcessor
{
    private PacketComparison $comparison;

    private array $buffer = [];

    public function __construct(PacketComparison $comparison = null)
    {
        $this->comparison = $comparison ?? new PacketComparison();
    }

    public function addPacket(Packet $packet): void
    {
        if ($packet->isNull()) {
            return;
        }

        $this->buffer[] = $packet;
    }

    public function orderPackets(): void
    {
        $this->buffer[] = Packet::fromLine('[[2]]');
        $this->buffer[] = Packet::fromLine('[[6]]');

        usort($this->buffer, function (Packet $a, Packet $b) {
            $ordered = $this->comparison->packetsAreInOrder($a, $b);
            
            return $ordered ? -1 : 1;
        });
    }

    public function dumpBuffer(): string
    {
        return array_reduce($this->buffer, function (string $c, Packet $packet) {
            return $c . $packet . "\n";
        }, '');
    }

    public function decoderKey(): int
    {
        $dividers = [];

        /** @var Packet $packet */
        foreach ($this->buffer as $index => $packet) {
            $values = $packet->values();

            if (count($values) !== 1) {
                continue;
            }

            if (!is_array($values[0])) {
                continue;
            }

            if (count($values[0]) !== 1) {
                continue;
            }

            if (in_array($values[0][0], [2, 6], true)) {
                $dividers[] = $index + 1;
            }
        }

        return array_product($dividers);
    }
}
