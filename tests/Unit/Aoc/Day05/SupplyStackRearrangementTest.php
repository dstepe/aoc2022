<?php

namespace Tests\Unit\Aoc\Day05;

use App\Aoc\Day05\SupplyStackRearrangement;
use PHPUnit\Framework\TestCase;

class SupplyStackRearrangementTest extends TestCase
{
    public function testReadsStartingArrangement(): void
    {
        $manifest = [
            '        [Q] [B]         [H]        ',
            '    [F] [W] [D] [Q]     [S]        ',
            '    [D] [C] [N] [S] [G] [F]        ',
            '    [R] [D] [L] [C] [N] [Q]     [R]',
            '[V] [W] [L] [M] [P] [S] [M]     [M]',
            '[J] [B] [F] [P] [B] [B] [P] [F] [F]',
            '[B] [V] [G] [J] [N] [D] [B] [L] [V]',
            '[D] [P] [R] [W] [H] [R] [Z] [W] [S]',
            ' 1   2   3   4   5   6   7   8   9 ',
            '',
        ];

        $arranger = new SupplyStackRearrangement(new \ArrayIterator($manifest));

        $arranger->arrangeCrates();

        $this->assertEquals('VFQBQGHFR', $arranger->topCrates());
    }

    public function testMovesCrateBetweenStacks(): void
    {
        $manifest = [
            '[D]        ',
            '[N] [C]    ',
            '[Z] [M] [P]',
            ' 1   2   3 ',
            '',
            'move 1 from 1 to 2',
        ];

        $arranger = new SupplyStackRearrangement(new \ArrayIterator($manifest));

        $arranger->arrangeCrates();

        $this->assertEquals('NDP', $arranger->topCrates());
    }

    public function testMovesMultipleCratesBetweenStacks(): void
    {
        $manifest = [
            '[D]        ',
            '[N] [C]    ',
            '[Z] [M] [P]',
            ' 1   2   3 ',
            '',
            'move 2 from 1 to 2',
        ];

        $arranger = new SupplyStackRearrangement(new \ArrayIterator($manifest));

        $arranger->arrangeCrates();

        $this->assertEquals('ZNP', $arranger->topCrates());
    }

    public function testProcessesAllInstructionsBetweenStacks(): void
    {
        $manifest = [
            '    [D]    ',
            '[N] [C]    ',
            '[Z] [M] [P]',
            ' 1   2   3 ',
            '',
            'move 1 from 2 to 1',
            'move 3 from 1 to 3',
            'move 2 from 2 to 1',
            'move 1 from 1 to 2',
        ];

        $arranger = new SupplyStackRearrangement(new \ArrayIterator($manifest));

        $arranger->arrangeCrates();

        $this->assertEquals('CMZ', $arranger->topCrates());
    }
}
