<?php

namespace App\Aoc\Day14;

class Point
{
    public const AIR_LABEL = '.';
    public const SAND_START_LABEL = '+';
    public const STONE_LABEL = '#';
    public const SAND_LABEL = 'o';

    private string $role = self::AIR_LABEL;

    private Coordinates $coordinates;

    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function label(): string
    {
        return $this->role;
    }

    public function coordinates(): Coordinates
    {
        return $this->coordinates;
    }

    public function makeSandStart(): void
    {
        $this->role = self::SAND_START_LABEL;
    }

    public function makeStone(): void
    {
        $this->role = self::STONE_LABEL;
    }

    public function makeSand(): void
    {
        $this->role = self::SAND_LABEL;
    }

    public function canHoldSand(): bool
    {
        return $this->role === self::AIR_LABEL;
    }
}
