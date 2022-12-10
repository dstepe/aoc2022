<?php

namespace Tests\Unit\Aoc\Day05;

use App\Aoc\Day05\SupplyCrate;
use App\Aoc\Day05\SupplyStack;
use App\Aoc\Day05\SupplyStackRearrangement;
use PHPUnit\Framework\TestCase;

class SupplyStackTest extends TestCase
{
    public function testAddsCrates(): void
    {
        $stack = new SupplyStack();

        $stack->pushCrate(new SupplyCrate('A'));

        $this->assertEquals(1, $stack->count());
    }

    public function testGetsTopCrate(): void
    {
        $stack = new SupplyStack();

        $stack->pushCrate(new SupplyCrate('B'));
        $stack->pushCrate(new SupplyCrate('A'));

        $this->assertEquals('A', $stack->topCrate()->label());
    }

    public function testMovesCrateInMode(): void
    {
        $stack1 = new SupplyStack();
        $stack2 = new SupplyStack();

        $stack1->pushCrate(new SupplyCrate('B'));
        $stack1->pushCrate(new SupplyCrate('A'));
        $stack2->pushCrate(new SupplyCrate('C'));

        $stack1->move(1)->toStack($stack2);

        $this->assertEquals('B', $stack1->topCrate()->label());
        $this->assertEquals('A', $stack2->topCrate()->label());
    }

    public function testMovesCrateInSingleMode(): void
    {
        $stack1 = new SupplyStack();
        $stack2 = new SupplyStack();

        $stack1->pushCrate(new SupplyCrate('B'));
        $stack1->pushCrate(new SupplyCrate('A'));
        $stack1->pushCrate(new SupplyCrate('C'));
        $stack2->pushCrate(new SupplyCrate('D'));

        $stack1->move(2)->toStack($stack2);

        $this->assertEquals('B', $stack1->topCrate()->label());
        $this->assertEquals('A', $stack2->topCrate()->label());
    }

    public function testMovesCrateInMultiMode(): void
    {
        $stack1 = new SupplyStack();
        $stack2 = new SupplyStack();

        $stack1->pushCrate(new SupplyCrate('B'));
        $stack1->pushCrate(new SupplyCrate('A'));
        $stack1->pushCrate(new SupplyCrate('C'));
        $stack2->pushCrate(new SupplyCrate('D'));

        $stack1->move(2, SupplyStackRearrangement::MULTI_MODE)->toStack($stack2);

        $this->assertEquals('B', $stack1->topCrate()->label());
        $this->assertEquals('C', $stack2->topCrate()->label());
    }
}
