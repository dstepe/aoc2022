<?php

namespace Tests\Unit\Aoc\Day09;

use App\Aoc\Day09\ChangeCalculator;
use App\Aoc\Day09\Position;
use PHPUnit\Framework\TestCase;

class ChangeCalculatorTest extends TestCase
{
    /**
     * @dataProvider noChangeChecks
     */
    public function testNoChangeIfTouching(int $headRow, int $headColumn, int $tailRow, int $tailColumn): void
    {
        $calculator = new ChangeCalculator();

        $head = Position::makePosition()->withRow($headRow)->withColumn($headColumn);
        $tail = Position::makePosition()->withRow($tailRow)->withColumn($tailColumn);

        $change = $calculator->calculateChange($head, $tail);

        $this->assertEquals(0, $change->rows());
        $this->assertEquals(0, $change->columns());
    }

    public function noChangeChecks(): array
    {
        return [
            'right' => [2, 3, 2, 2],
            'down' => [2, 3, 1, 3],
            'left' => [2, 3, 2, 4],
            'up' => [2, 3, 3, 3],
            'up-right' => [2, 3, 3, 4],
            'down-right' => [2, 3, 1, 4],
            'down-left' => [2, 3, 1, 2],
            'up-left' => [2, 3, 3, 2],
        ];
    }

    /**
     * @dataProvider directFollowChecks
     */
    public function testFollowsDirectLine(int $headRow, int $headColumn, int $tailRow, int $tailColumn, int $expectedRow, int $expectedColumn): void
    {
        $calculator = new ChangeCalculator();

        $head = Position::makePosition()->withRow($headRow)->withColumn($headColumn);
        $tail = Position::makePosition()->withRow($tailRow)->withColumn($tailColumn);

        $change = $calculator->calculateChange($head, $tail);

        $this->assertEquals($expectedRow, $change->rows());
        $this->assertEquals($expectedColumn, $change->columns());
    }

    public function directFollowChecks(): array
    {
        return [
            'right' => [5, 5, 5, 3, 0, 1],
            'down' => [5, 5, 7, 5, -1, 0],
            'left' => [5, 5, 5, 7, 0, -1],
            'up' => [5, 5, 3, 5, 1, 0],
        ];
    }

    /**
     * @dataProvider diagonalFollowChecks
     */
    public function testFollowsDiagonalChange(int $headRow, int $headColumn, int $tailRow, int $tailColumn, int $expectedRow, int $expectedColumn): void
    {
        $calculator = new ChangeCalculator();

        $head = Position::makePosition()->withRow($headRow)->withColumn($headColumn);
        $tail = Position::makePosition()->withRow($tailRow)->withColumn($tailColumn);

        $change = $calculator->calculateChange($head, $tail);

        $this->assertEquals($expectedRow, $change->rows());
        $this->assertEquals($expectedColumn, $change->columns());
    }

    public function diagonalFollowChecks(): array
    {
        return [
            'up-right' => [3, 3, 1, 2, 1, 1],
            'down-right' => [3, 3, 5, 2, -1, 1],
            'down-left' => [3, 3, 5, 4, -1, -1],
            'up-left' => [3, 3, 1, 4, 1, -1],
        ];
    }
}
