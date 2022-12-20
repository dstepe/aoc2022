<?php

namespace App\Aoc\Day14;

use Illuminate\Support\Collection;

class CaveMap
{
    private RockPaths $rockPaths;

    private Collection $map;

    private int $xMin;
    private int $xMax;
    private int $yMin = 0;
    private int $yMax;

    private Collection $xIndexes;

    private Coordinates $sandSource;

    public function __construct(RockPaths $rockPaths)
    {
        $this->rockPaths = $rockPaths;

        $this->droppedSand = new Collection();
        $this->sandSource = Coordinates::fromInts(500, 0);

        $this->initializeMap();
    }

    /**
     * @param Coordinates $coordinates
     * @return Point
     * @throws FellToAbyssException
     */
    public function findPoint(Coordinates $coordinates): Point
    {
        if ($coordinates->y() > $this->yMax) {
            throw new FellToAbyssException();
        }

        $this->expandMap($coordinates);

        /** @var MapRow $row */
        $row = $this->map->get($coordinates->y());

        return $row->get($this->xIndexes->get($coordinates->x()));
    }

    public function sandSource(): Coordinates
    {
        return $this->sandSource;
    }

    public function renderMap(): string
    {
        return $this->map->reduce(function (string $c, MapRow $row) {
            return $c . $row->reduce(function (string $r, Point $point) {
                    return $r . $point->label();
                }, '') . "\n";
        }, '');
    }

    private function markSandStart(): void
    {
        $point = $this->findPoint($this->sandSource);
        $point->makeSandStart();
    }

    private function initializeMap(): void
    {
        $this->xMin = $this->rockPaths->xMinimum() - 1;
        $this->xMax = $this->rockPaths->xMaximum() + 1;
        $this->yMax = $this->rockPaths->yMaximum() + 2; // add space for floor

        $this->map = new Collection();
        $this->xIndexes = new Collection();

        for ($y = 0; $y <= $this->yMax; $y++) {
            $row = new MapRow();
            for ($x = $this->xMin; $x <= $this->xMax; $x++) {
                $row->add(new Point(Coordinates::fromInts($x, $y)));
            }
            $this->map->add($row);
        }

        /** @var Collection $lastRow */
        $lastRow = $this->map->last();
        $lastRow->each(function (Point $point) {
            $point->makeStone();
        });

        $this->reIndex();

        $this->markSandStart();

        $this->rockPaths->each(function (RockPath $rockPath) {
            $rockPath->makePath()->each(function (Coordinates $coordinates) {
                $point = $this->findPoint($coordinates);
                $point->makeStone();
            });
        });
    }

    private function reIndex(): void
    {
        $this->xIndexes = new Collection();

        for ($x = $this->xMin, $i = 0; $x <= $this->xMax; $x++, $i++) {
            $this->xIndexes->put($x, $i);
        }
    }

    private function expandMap(Coordinates $coordinates): void
    {
        if ($coordinates->x() <= $this->xMax && $coordinates->x() >= $this->xMin) {
            return;
        }

        if ($coordinates->x() > $this->xMax) {
            $this->appendColumn($coordinates);
            return;
        }

        $this->prependColumn($coordinates);
    }

    private function appendColumn(Coordinates $coordinates): void
    {
        $this->map->each(function (MapRow $row) use ($coordinates) {
            /** @var Point $first */
            $first = $row->first();

            $row->add(new Point(Coordinates::fromInts($coordinates->x(), $first->coordinates()->y())));
        });

        $this->map->last()->last()->makeStone();

        $this->xMax = $coordinates->x();
        $this->reIndex();
    }

    private function prependColumn(Coordinates $coordinates): void
    {
        $this->map->each(function (MapRow $row) use ($coordinates) {
            /** @var Point $first */
            $first = $row->first();

            $row->prepend(new Point(Coordinates::fromInts($coordinates->x(), $first->coordinates()->y())));
        });

        $this->map->last()->first()->makeStone();

        $this->xMin = $coordinates->x();
        $this->reIndex();
    }
}
