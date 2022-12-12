<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Action;
use PHPUnit\Framework\TestCase;

class ActionTest extends TestCase
{
    public function testCreatesFromNote(): void
    {
        $action = Action::fromNote('   If true: throw to monkey 2');

        $this->assertTrue($action->condition());
        $this->assertEquals('throw to monkey 2', $action->spec());
    }
}
