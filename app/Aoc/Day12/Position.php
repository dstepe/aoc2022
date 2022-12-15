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

    public function upNeighbor(Position $position): void
    {
        $this->upNeighbor = $position;
    }

    public function rightNeighbor(Position $position): void
    {
        $this->rightNeighbor = $position;
    }

    public function downNeighbor(Position $position): void
    {
        $this->downNeighbor = $position;
    }

    public function leftNeighbor(Position $position): void
    {
        $this->leftNeighbor = $position;
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

    public function findNextPosition(): Position
    {
        $candidates = [];

        // Prefer vertical moves so put them first
        if ($this->canMoveUp()) {
            $candidates[] = [
                'direction' => 'up',
                'position' => $this->upNeighbor,
                'score' => $this->moveScore($this->upNeighbor),
            ];
        }

        if ($this->canMoveDown()) {
            $candidates[] = [
                'direction' => 'down',
                'position' => $this->downNeighbor,
                'score' => $this->moveScore($this->downNeighbor),
            ];
        }

        if ($this->canMoveRight()) {
            $candidates[] = [
                'direction' => 'right',
                'position' => $this->rightNeighbor,
                'score' => $this->moveScore($this->rightNeighbor),
            ];
        }

        if ($this->canMoveLeft()) {
            $candidates[] = [
                'direction' => 'left',
                'position' => $this->leftNeighbor,
                'score' => $this->moveScore($this->leftNeighbor),
            ];
        }

        if (empty($candidates)) {
            throw new \InvalidArgumentException('Now neighbors are a candidate to move to from: %s', $this->location());
        }

        $selected = array_reduce($candidates, function (array $moveTo, array $candidate) {
            if (empty($moveTo) || $candidate['score'] < $moveTo['score']) {
                $moveTo = $candidate;
            }

            return $moveTo;
        }, []);

        return $selected['position'];
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
        return abs($position->height() - $this->height) <= 1;
    }

    public function moveScore(Position $position): int
    {
        // ensure Position is a neighbor
        if (abs($this->row - $position->row()) > 1 || abs($this->column - $position->column()) > 1) {
            throw new \InvalidArgumentException(sprintf('%s is not a neighor of %s', $this->location(), $position->location()));
        }

        $verticalDistanceToEnd = abs($position->row - $this->end->row());
        $horizontalDistanceToEnd = abs($position->column - $this->end->column());
        $elevationDifference = $position->height() - $this->height;

        printf("Current: %s, neighbor: %s, end: %s\n", $this->location(), $position->location(), $this->end->location());
        printf("VDist: %s, HDist: %s, EDiff: %s\n", $verticalDistanceToEnd, $horizontalDistanceToEnd, $elevationDifference);
        return $verticalDistanceToEnd + $horizontalDistanceToEnd;
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
