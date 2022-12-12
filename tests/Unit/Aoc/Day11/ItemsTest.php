<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Items;
use PHPUnit\Framework\TestCase;

class ItemsTest extends TestCase
{
    public function testCreatesFromNote(): void
    {
        $items = Items::fromNote('  Starting items: 79, 98');

        $this->assertCount(2, $items);
    }

    public function testCreatesCorrectItemsInOrder(): void
    {
        $items = Items::fromNote('  Starting items: 79, 98');

        $this->assertEquals(79, $items->get(0)->worryLevel());
        $this->assertEquals(98, $items->get(1)->worryLevel());
    }
}
