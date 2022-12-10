<?php

namespace App\Aoc\Day09;

use Illuminate\Support\Collection;

class Position
{
    public const EMPTY_MARKER = '.';
    public const NOT_VISITED_MARKER = '.';
    public const VISITED_MARKER = '#';

    private int $row = 0;
    private int $col = 0;

    private OccupantCollection $occupants;

    private bool $isStartPosition = false;

    private bool $visited = false;

    private array $neighbors = [];

    private function __construct(int $x, int $y, OccupantCollection $occupants)
    {
        $this->occupants = $occupants;
    }

    public static function makePosition(): self
    {
        return new self(0, 0, new OccupantCollection());
    }

    public function withRow(int $row): self
    {
        $this->row = $row;
        return $this;
    }

    public function withColumn(int $column): self
    {
        $this->col = $column;
        return $this;
    }

    public function withOccupants(Occupant ...$occupants): self
    {
        foreach ($occupants as $occupant) {
            $this->arrives($occupant);
        }

        return $this;
    }

    public function shiftRight(): void
    {
        $this->col++;
    }

    public function shiftUp(): void
    {
        $this->row++;
    }

    public function row(): int
    {
        return $this->row;
    }

    public function column(): int
    {
        return $this->col;
    }

    public function occupantMarker(): string
    {
        return $this->occupants->occupantMarker();
    }

    public function visitedMarker(): string
    {
        if ($this->isStartPosition) {
            return Start::MARKER;
        }

        if ($this->visited) {
            return self::VISITED_MARKER;
        }

        return self::EMPTY_MARKER;
    }

    public function wasVisited(): bool
    {
        return $this->isStartPosition || $this->visited;
    }

    public function arrives(Occupant $occupant): void
    {
        if ($occupant->marker() === Start::MARKER) {
            $this->isStartPosition = true;
        }

        if ($occupant->shouldVisit()) {
            $this->visited = true;
        }

        $this->occupants->add($occupant);
    }

    public function leaves(Occupant $occupant): void
    {
        $this->occupants->remove($occupant);
    }

    public function getNeighbor(string $direction): Position
    {
        if (empty($this->neighbors[$direction])) {
            $this->neighbors[$direction] = self::makePosition();
        }

        return $this->neighbors[$direction];
    }
}
