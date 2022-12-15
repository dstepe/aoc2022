<?php

namespace Tests\Unit\Aoc\Day12;

use App\Aoc\Day12\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    /**
     * @dataProvider heightFromLabelChecks
     */
    public function testGetsHeightFromLabel(string $label, int $expected): void
    {
        $position = new Position($label, 0, 0);

        $this->assertEquals($expected, $position->height());
    }

    public function heightFromLabelChecks(): array
    {
        return [
            'a' => ['a', 0],
            'm' => ['m', 12],
            'z' => ['z', 25],
            'S' => ['S', 0],
            'E' => ['E', 25],
        ];
    }

    /**
     * @dataProvider calculateMoveScoreChecks
     */
    public function testCalculatesMoveScoreFromPosition(Position $position, string $neighborLabel, string $neighborHeight, int $expected): void
    {
        $endPosition = new Position('E', 6, 8);
        $neighbor = $this->makeNeighbor($position, $neighborLabel, $neighborHeight);

        $position->endPosition($endPosition);

//        printf("Current: %s, neighbor: %s, end: %s\n", $position->location(), $neighbor->location(), $endPosition->location());

        $this->assertEquals($expected, $position->moveScore($neighbor));
    }

    private function makeNeighbor(Position $position, string $neighborLabel, string $neighborHeight): Position
    {
        if ($neighborLabel === 'up') {
            $row = $position->row() - 1;
            $column = $position->column();
        }

        if ($neighborLabel === 'right') {
            $row = $position->row();
            $column = $position->column() + 1;
        }

        if ($neighborLabel === 'down') {
            $row = $position->row() + 1;
            $column = $position->column();
        }

        if ($neighborLabel === 'left') {
            $row = $position->row();
            $column = $position->column() - 1;
        }

        if ($row < 0 || $column < 0) {
            throw new \InvalidArgumentException('Cannot have neighbor past first row or column');
        }

        return new Position($neighborHeight, $row, $column);
    }

    public function calculateMoveScoreChecks(): array
    {
        return [
//            [new Position('b', 0, 0), 'right', 'c', 0],
//            [new Position('b', 0, 0), 'down', 'c', 0],
//            [new Position('S', 0, 0), 'right', 'a', 0],
//            [new Position('S', 0, 0), 'down', 'a', 0],
//            [new Position('a', 1, 0), 'up', 'a', 0],
//            [new Position('a', 1, 0), 'right', 'b', 0],
//            [new Position('a', 1, 0), 'down', 'a', 0],
//            [new Position('c', 2, 2), 'right', 'c', 0],
//            [new Position('c', 2, 2), 'down', 'c', 0],
            [new Position('c', 2, 2), 'up', 'c', 0],
            [new Position('c', 2, 2), 'left', 'c', 0],
            [new Position('c', 2, 2), 'down', 'c', 0],
        ];
    }

    public function testFindsNextPosition(): void
    {
        $pRow = 2;
        $pCol = 2;

        $position = new Position('c', $pRow, $pCol);
        $end = new Position('z', 2, 5);
        $up = new Position('c', $pRow - 1, $pCol);
        $right = new Position('s', $pRow, $pCol + 1);
        $down = new Position('c', $pRow + 1, $pCol);
        $left = new Position('c', $pRow, $pCol - 1);

        $position->endPosition($end);
        $position->upNeighbor($up);
        $position->rightNeighbor($right);
        $position->downNeighbor($down);
        $position->leftNeighbor($left);

        $next = $position->findNextPosition();
        print $next->location() . "\n";

        $this->assertEquals($down, $next);
    }
}
