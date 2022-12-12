<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Item;
use App\Aoc\Day11\Operation;
use PHPUnit\Framework\TestCase;

class OperationTest extends TestCase
{
    public function testCreatesFromNote(): void
    {
        $operation = Operation::fromNote('  Operation: new = old * 19');

        $this->assertEquals('old * 19', $operation->spec());
    }

    public function testExecutesOperationWithRelief(): void
    {
        $operation = Operation::fromNote('  Operation: new = old * 4');

        $item = new Item(2);

        $expected = (int) floor((2 * 4) / 3);
        $this->assertEquals($expected, $operation->evaluate($item));
    }
}
