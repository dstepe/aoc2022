<?php

namespace App\Aoc\Day09;

use Illuminate\Support\Collection;

class Bridge
{
    private Collection $rows;

    private ChangeCalculator $changeCalculator;

    private Occupant $start;
    private Occupant $head;
    private Occupant $tail;

    private Position $headPosition;
    private Position $tailPosition;

    public function __construct()
    {
        $this->changeCalculator = new ChangeCalculator();

        $this->start = new Start();
        $this->head = new Head();
        $this->tail = new Tail();

        $this->rows = new Collection();

        $this->headPosition = Position::makePosition()->withOccupants($this->start, $this->head, $this->tail);
        $this->tailPosition = $this->headPosition;

        $this->rows->add(new Row([$this->headPosition]));
    }

    public function occupantMap(): string
    {
        $this->fillUnvisitedPositions();

        return $this->rows->reverse()->reduce(function (string $c, Row $row) {
            $c .= $row->occupantMap() . "\n";
            return $c;
        }, '');
    }

    public function visitedMap(): string
    {
        $this->fillUnvisitedPositions();

        return $this->rows->reverse()->reduce(function (string $c, Row $row) {
            $c .= $row->visitedMap() . "\n";
            return $c;
        }, '');
    }

    public function visitedCount(): int
    {
        return $this->rows->reduce(function (int $c, Row $row) {
            return $c + $row->visitedCount();
        }, 0);
    }

    public function move(string $direction, int $steps): void
    {
        for ($i = 0; $i < $steps; $i++) {
            $this->step($direction);
        }
    }

    private function step(string $direction): void
    {
        switch ($direction) {
            case 'R':
                $moveRow = 0;
                $moveColumn = 1;
                break;

            case 'U':
                $moveRow = 1;
                $moveColumn = 0;
                break;

            case 'L':
                $moveRow = 0;
                $moveColumn = -1;
                $this->ensureColumnLeft();
                break;

            case 'D':
                $moveRow = -1;
                $moveColumn = 0;
                $this->ensureRowDown();
                break;
        }

        $nextPosition = $this->getPosition($this->headPosition->row() + $moveRow, $this->headPosition->column() + $moveColumn);

        $this->head->leaves($this->headPosition);
        $this->head->enters($nextPosition);
        $this->headPosition = $nextPosition;

        $this->adjustTail();
    }

    private function ensureColumnLeft(): void
    {
        if ($this->headPosition->column() > 0) {
            return;
        }

        $this->insertColumnLeft();
    }

    private function insertColumnLeft(): void
    {
        $this->rows->each(function (Row $row) {
            $row->each(function (Position $position) {
                $position->shiftRight();
            });

            /** @var Position $firstPosition */
            $firstPosition = $row->first();
            $row->prepend(Position::makePosition()
                ->withRow($firstPosition->row())
                ->withColumn(0)
            );
        });
    }

    private function ensureRowDown(): void
    {
        if ($this->headPosition->row() > 0) {
            return;
        }

        $this->insertRowDown();
    }

    private function insertRowDown(): void
    {
        $this->rows->each(function (Row $row) {
            $row->each(function (Position $position) {
                $position->shiftUp();
            });
        });

        $length = $this->rows->first()->count();

        $newRow = new Row();

        while ($newRow->count() < $length) {
            $newRow->add(Position::makePosition()
                ->withRow(0)
                ->withColumn($newRow->count()));
        }

        $this->rows->prepend($newRow);
    }

    private function getPosition(int $row, int $column): Position
    {
        if ($row < 0) {
            throw new \InvalidArgumentException('Row cannot be less than 0');
        }

        if ($column < 0) {
            throw new \InvalidArgumentException('Column cannot be less than 0');
        }

        if ($this->rows->count() <= $row) {
            $this->rows->add(new Row());
        }

        /** @var Row $targetRow */
        $targetRow = $this->rows->get($row);

        While ($targetRow->count() <= $column) {
            $targetRow->add(Position::makePosition()->withRow($row)->withColumn($targetRow->count()));
        }

        return $targetRow->get($column);
    }

    private function adjustTail(): void
    {
        $change = $this->changeCalculator->calculateChange($this->headPosition, $this->tailPosition);

        if ($change->noChange()) {
            return;
        }

        $nextPosition = $this->getPosition($this->tailPosition->row() + $change->rows(), $this->tailPosition->column() + $change->columns());

        $this->tail->leaves($this->tailPosition);
        $this->tail->enters($nextPosition);
        $this->tailPosition = $nextPosition;
    }

    private function fillUnvisitedPositions(): void
    {
        // TODO replace with addColumn that does all rows at once
        $maxLength = $this->rows->reduce(function (int $c, Row $row) {
            return max($row->count(), $c);
        }, 0);

        $this->rows->each(function (Row $row) use ($maxLength) {
            if ($row->count() === $maxLength) {
                return;
            }

            /** @var Position $lastPosition */
            $lastPosition = $row->last();
            $rowNum = $lastPosition->row();
            $columnNum = $lastPosition->column();

            while ($row->count() < $maxLength) {
                $row->add(Position::makePosition()->withRow($rowNum)->withColumn(++$columnNum));
            }
        });
    }
}
