<?php

namespace App\Aoc\Day12;

class Position
{
    public const NOT_VISITED_MARKER = '.';
    public const UP_MARKER = '^';
    public const RIGHT_MARKER = '>';
    public const DOWN_MARKER = 'v';
    public const LEFT_MARKER = '<';

    private string $label;
    private int $height;
    private int $row;
    private int $column;

    private string $marker = self::NOT_VISITED_MARKER;

    private Position $upNeighbor;
    private Position $rightNeighbor;
    private Position $downNeighbor;
    private Position $leftNeighbor;
    private Position $end;

    public function __construct(string $label, int $row, int $column)
    {
        $this->label = $label;
        $this->row = $row;
        $this->column = $column;

        $this->setHeight();
    }

    public function label(): string
    {
        return $this->label;
    }

    public function marker(): string
    {
        if ($this->label === 'E') {
            return $this->label;
        }

        return $this->marker;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function row(): int
    {
        return $this->row;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function location(): string
    {
        return sprintf('%s:%s', $this->row, $this->column);
    }

    public function addUpNeighbor(Position $position): void
    {
        $this->upNeighbor = $position;
    }

    public function upNeighbor(): Position
    {
        return $this->upNeighbor;
    }

    public function addRightNeighbor(Position $position): void
    {
        $this->rightNeighbor = $position;
    }

    public function rightNeighbor(): Position
    {
        return $this->rightNeighbor;
    }

    public function addDownNeighbor(Position $position): void
    {
        $this->downNeighbor = $position;
    }

    public function downNeighbor(): Position
    {
        return $this->downNeighbor;
    }

    public function addLeftNeighbor(Position $position): void
    {
        $this->leftNeighbor = $position;
    }

    public function leftNeighbor(): Position
    {
        return $this->leftNeighbor;
    }

    public function endPosition(Position $end): void
    {
        $this->end = $end;
    }

    public function is(Position $position): bool
    {
        return $this === $position;
    }

    public function isNot(Position $position): bool
    {
        return !$this->is($position);
    }

    public function isEnd(): bool
    {
        return $this->is($this->end);
    }

    public function canMoveUp(): bool
    {
        if (empty($this->upNeighbor)) {
            return false;
        }

        return $this->canMoveTo($this->upNeighbor);
    }

    public function canMoveRight(): bool
    {
        if (empty($this->rightNeighbor)) {
            return false;
        }

        return $this->canMoveTo($this->rightNeighbor);
    }

    public function canMoveDown(): bool
    {
        if (empty($this->downNeighbor)) {
            return false;
        }

        return $this->canMoveTo($this->downNeighbor);
    }

    public function canMoveLeft(): bool
    {
        if (empty($this->leftNeighbor)) {
            return false;
        }

        return $this->canMoveTo($this->leftNeighbor);
    }

    private function canMoveTo(Position $position): bool
    {
        return $position->height() <= $this->height + 1;
    }

    public function leaveFor(Position $position): void
    {
        if (!empty($this->upNeighbor) && $position->is($this->upNeighbor)) {
            $this->marker = self::UP_MARKER;
            return;
        }

        if (!empty($this->rightNeighbor) && $position->is($this->rightNeighbor)) {
            $this->marker = self::RIGHT_MARKER;
            return;
        }

        if (!empty($this->downNeighbor) && $position->is($this->downNeighbor)) {
            $this->marker = self::DOWN_MARKER;
            return;
        }

        if (!empty($this->leftNeighbor) && $position->is($this->leftNeighbor)) {
            $this->marker = self::LEFT_MARKER;
            return;
        }

        throw new \InvalidArgumentException('Tried to leave for position that is not a neighbor');
    }

    public function __toString(): string
    {
        return $this->location();
    }

    private function setHeight(): void
    {
        $indicator = match ($this->label) {
            'S' => 'a',
            'E' => 'z',
            default => $this->label,
        };

        $this->height = ord($indicator) - 97;
    }
}
