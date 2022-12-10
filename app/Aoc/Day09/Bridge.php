<?php

namespace App\Aoc\Day09;

use Illuminate\Support\Collection;

class Bridge
{
    private Collection $rows;

    private ChangeCalculator $changeCalculator;

    private Knot $start;
    private Knot $head;

    private Position $headPosition;

    private Collection $knots;

    public function __construct()
    {
        $this->changeCalculator = new ChangeCalculator();

        $this->start = Knot::start();
        $this->head = Knot::head();

        $this->knots = new KnotCollection();
        $this->knots->addKnot($this->head);
        $this->knots->addKnot(Knot::knot(1));
        $this->knots->addKnot(Knot::knot(2));
        $this->knots->addKnot(Knot::knot(3));
        $this->knots->addKnot(Knot::knot(4));
        $this->knots->addKnot(Knot::knot(5));
        $this->knots->addKnot(Knot::knot(6));
        $this->knots->addKnot(Knot::knot(7));
        $this->knots->addKnot(Knot::knot(8));
        $this->knots->addKnot(Knot::tail());

        $this->rows = new Collection();

        $this->headPosition = Position::makePosition()->withOccupants($this->start);

        $this->knots->each(function (Knot $knot) {
            $knot->enters($this->headPosition);
        });

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

        $this->adjustFollowers();
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

    private function adjustFollowers(): void
    {
        $length = $this->knots->count();
        for ($a = 0, $b = 1; $b < $length; $a++, $b++) {
            /** @var Knot $aKnot */
            $aKnot = $this->knots->get($a);
            /** @var Knot $bKnot */
            $bKnot = $this->knots->get($b);

            /** @var Position $aPosition */
            $aPosition = $aKnot->position();
            /** @var Position $bPosition */
            $bPosition = $bKnot->position();

            $change = $this->changeCalculator->calculateChange($aPosition, $bPosition);

            if ($change->noChange()) {
                continue;
            }

            $nextPosition = $this->getPosition($bPosition->row() + $change->rows(), $bPosition->column() + $change->columns());

            $bKnot->leaves($bPosition);
            $bKnot->enters($nextPosition);
        }
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
