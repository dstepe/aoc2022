<?php

namespace Tests\Unit\Aoc\Day08;

use App\Aoc\Day08\TreetopView;
use PHPUnit\Framework\TestCase;

class TreetopViewTest extends TestCase
{
    public function testParsesForestMap(): void
    {
        $view = new TreetopView(new \ArrayIterator($this->inputMap()));

        $view->makeMap();

        $expected = implode("\n", $this->inputMap()) . "\n";
        $this->assertEquals($expected, $view->map());
    }

    public function testCountsVisibleTrees(): void
    {
        $view = new TreetopView(new \ArrayIterator($this->inputMap()));

        $view->makeMap();

        $this->assertEquals(21, $view->visible());
    }

    public function testFindsHighestScenicScore(): void
    {
        $view = new TreetopView(new \ArrayIterator($this->inputMap()));

        $view->makeMap();

        $this->assertEquals(8, $view->highestScenicScore());
    }

    private function inputMap(): array
    {
        return [
            '30373',
            '25512',
            '65332',
            '33549',
            '35390',
        ];
    }
}
