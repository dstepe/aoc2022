<?php

namespace App\Aoc\Day14;

use Illuminate\Support\Collection;

class Scanner
{
    public const COORDINATE_DELIMITER = ' -> ';

    private RockPaths $rockPaths;

    public function __construct()
    {
        $this->rockPaths = new RockPaths();
    }

    public function processRockPath(string $pathCoordinates): void
    {
        $coordinates = new Collection(explode(self::COORDINATE_DELIMITER, $pathCoordinates));

        $path = $coordinates->reduce(function (RockPath $c, string $coordinates) {
            $c->add(Coordinates::fromString($coordinates));
            return $c;
        }, new RockPath());

        $this->rockPaths->add($path);
    }

    public function rockPaths(): RockPaths
    {
        return $this->rockPaths;
    }
}
