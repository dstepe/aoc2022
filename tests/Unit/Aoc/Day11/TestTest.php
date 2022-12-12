<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Actions;
use App\Aoc\Day11\Item;
use App\Aoc\Day11\Test;
use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
    public function testCreatesFromNote(): void
    {
        $actions = Actions::fromNotes('   If true: throw to monkey 2', '   If false: throw to monkey 3');

        $test = Test::fromNote('  Test: divisible by 23', $actions);

        $this->assertEquals('divisible by 23', $test->spec());
    }

    public function testReturnsExpectedActionWhenTestPasses(): void
    {
        $actions = Actions::fromNotes('   If true: throw to monkey 2', '   If false: throw to monkey 3');

        $test = Test::fromNote('  Test: divisible by 23', $actions);

        $action = $test->test(new Item(46));

        $this->assertEquals(2, $action->targetMonkey());
    }

    public function testReturnsExpectedActionWhenTestFails(): void
    {
        $actions = Actions::fromNotes('   If true: throw to monkey 2', '   If false: throw to monkey 3');

        $test = Test::fromNote('  Test: divisible by 23', $actions);

        $action = $test->test(new Item(15));

        $this->assertEquals(3, $action->targetMonkey());
    }
}
