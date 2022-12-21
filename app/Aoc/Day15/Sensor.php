<?php

namespace App\Aoc\Day15;

use Illuminate\Support\Collection;

class Sensor
{
    private Point $point;
    private Beacon $beacon;

    private int $distance;
    private int $coversLowY;
    private int $coversHighY;
    private int $coversLowX;
    private int $coversHighX;

    public function __construct(Point $point, Beacon $beacon)
    {
        $this->point = $point;
        $this->beacon = $beacon;

        $this->calculateDistance();
    }

    public function x(): int
    {
        return $this->point->x();
    }

    public function y(): int
    {
        return $this->point->y();
    }

    public function beacon(): Beacon
    {
        return $this->beacon;
    }

    public function minX(): int
    {
        return min($this->x(), $this->beacon->x());
    }

    public function maxX(): int
    {
        return max($this->x(), $this->beacon->x());
    }

    public function coversRow(int $rowNum): bool
    {
        return $this->coversLowY <= $rowNum && $this->coversHighY >= $rowNum;
    }

    public function coversFromX(): int
    {
        return $this->coversLowX;
    }

    public function coversToX(): int
    {
        return $this->coversHighX;
    }

    public function notCoversRow(int $rowNum): bool
    {
        return !$this->coversRow($rowNum);
    }

    public function positionsSeenInRow(int $rowNum): Range
    {
        if ($this->notCoversRow($rowNum)) {
            throw new \Exception('Row is not covered by sensor');
        }

        $relativeRowNum = abs($rowNum - $this->point->y());

        $gap = $this->distance - $relativeRowNum;

        $from = $this->point->x() - $gap;
        $to = $this->point->x() + $gap;

        return new Range(new Point($from, $rowNum), new Point($to, $rowNum));
    }

    private function calculateDistance(): void
    {
        $this->distance = abs($this->point->x() - $this->beacon->x())
            + abs($this->point->y() - $this->beacon->y());

        $this->coversLowY = $this->point->y() - $this->distance;
        $this->coversHighY = $this->point->y() + $this->distance;
        $this->coversLowX = $this->point->x() - $this->distance;
        $this->coversHighX = $this->point->x() + $this->distance;
    }
}
