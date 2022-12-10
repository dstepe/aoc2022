<?php

namespace App\Aoc\Day06;

class TuningTrouble
{
    public const PACKET_MARKER_SIZE = 4;
    public const MESSAGE_MARKER_SIZE = 14;

    private \Iterator $input;

    private string $seekMode = 'packet';

    private int $readCount = 0;

    private array $candidates = [];

    private int $startOfPacket = 0;
    private bool $foundStartOfPacket = false;

    private int $startOfMessage = 0;
    private bool $foundStartOfMessage = false;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
    }

    public function seek(): void
    {
        foreach ($this->input as $line) {
            $buffer = str_split($line);
            foreach ($buffer as $char) {
                $this->readChar($char);
                if ($this->foundStartOfMessage) {
                    return;
                }
            }
        }
    }

    public function startOfPacket(): int
    {
        return $this->startOfPacket;
    }

    public function startOfMessage(): int
    {
        return $this->startOfMessage;
    }

    private function readChar(string $char): void
    {
        $this->readCount++;

        $this->pushCandidate($char);

        if (count($this->candidates) !== $this->currentMarkerSize()) {
            return;
        }

        if ($this->seekMode === 'packet' && $this->isMarker()) {
            $this->startOfPacket = $this->readCount;
            $this->foundStartOfPacket = true;
            $this->seekMode = 'message';
        }

        if ($this->seekMode === 'message' && $this->isMarker()) {
            $this->startOfMessage = $this->readCount;
            $this->foundStartOfMessage = true;
        }
    }

    private function pushCandidate(string $char): void
    {
        $this->candidates[] = $char;

        if (count($this->candidates) > $this->currentMarkerSize()) {
            array_shift($this->candidates);
        }
    }

    private function currentMarkerSize(): int
    {
        if ($this->seekMode === 'packet') {
            return self::PACKET_MARKER_SIZE;
        }

        return self::MESSAGE_MARKER_SIZE;
    }

    private function isMarker(): bool
    {
        $uniqueChars = array_unique($this->candidates);

        return count($uniqueChars) === $this->currentMarkerSize();
    }
}
