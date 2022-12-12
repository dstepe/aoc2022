<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Action;
use App\Aoc\Day11\Actions;
use PHPUnit\Framework\TestCase;

class ActionsTest extends TestCase
{
    public function testCreatesFromNotes(): void
    {
        $actions = Actions::fromNotes('   If true: throw to monkey 2', '   If false: throw to monkey 3');

        $this->assertEquals('throw to monkey 2', $actions->onTrueSpec());
        $this->assertEquals('throw to monkey 3', $actions->onFalseSpec());
    }
}
