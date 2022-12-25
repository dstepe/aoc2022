<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Valve
{
    public const OPEN = 'open';
    public const CLOSED = 'closed';

    private string $label;
    private int $flowRate;
    private Collection $leadsTo;
    private string $state = self::CLOSED;

    public function __construct(string $label, int $flowRate, Collection $leadsTo)
    {
        $this->label = $label;
        $this->flowRate = $flowRate;
        $this->leadsTo = $leadsTo;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function flowRate(): int
    {
        return $this->flowRate;
    }

    public function leadsTo(string $label): bool
    {
        return $this->leadsTo->contains($label);
    }

    public function open(): void
    {
        $this->state = self::OPEN;
    }

    public function isOpen(): bool
    {
        return $this->state === self::OPEN;
    }

    public function isClosed(): bool
    {
        return !$this->isOpen();
    }

    public function potentialPressure(int $timeRemaining): int
    {
        return $this->flowRate * $timeRemaining;
    }
}
