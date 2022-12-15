<?php

namespace App\Aoc\Day12;

use Illuminate\Support\Collection;

class Map
{
    private Collection $rows;

    private Position $start;
    private Position $end;

    public function __construct()
    {
        $this->rows = new Collection;
    }

    public function makeRow(string $line): void
    {
        $rowNumber = $this->rows->count();
        $previousRow = $this->rows->last();

        $row = new Row();
        $this->rows->add($row);

        foreach (str_split($line) as $height) {
            $position = new Position($height, $rowNumber, $row->count());

            if ($row->count() > 0) {
                /** @var Position $leftNeighbor */
                $leftNeighbor = $row->last();
                $position->leftNeighbor($leftNeighbor);
                $leftNeighbor->rightNeighbor($position);
            }

            if (null !== $previousRow) {
                /** @var Position $upNeighbor */
                $upNeighbor = $previousRow->get($row->count());
                $position->upNeighbor($upNeighbor);
                $upNeighbor->downNeighbor($position);
            }

            $row->add($position);

            if (!empty($this->end)) {
                $position->endPosition($this->end);
            }

            if ($position->label() === 'S') {
                $this->start = $position;
            }

            if ($position->label() === 'E') {
                $this->end = $position;
                $this->setEnd();
            }
        }
    }

    public function start(): Position
    {
        return $this->start;
    }

    public function end(): Position
    {
        return $this->end;
    }

    public function map(): string
    {
        return $this->rows->reduce(function (string $c, Row $row) {
            return $c . $row->mapRow() . "\n";
        }, '');
    }

    public function route(): string
    {
        return $this->rows->reduce(function (string $c, Row $row) {
            return $c . $row->markers() . "\n";
        }, '');
    }

    public function size(): int
    {
        return $this->rows->reduce(function (int $c, Row $row) {
            return $c + $row->count();
        }, 0);
    }

    private function setEnd(): void
    {
        $this->rows->each(function (Row $row) {
            $row->each(function (Position $position) {
                $position->endPosition($this->end);
            });
        });
    }
}
