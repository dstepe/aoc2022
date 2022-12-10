<?php

namespace Tests\Unit\Aoc\Day08;

use App\Aoc\Day08\Tree;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{
    public function testFindsScenicViewNorth(): void
    {
        $tree1 = new Tree(0, 5);
        $tree2 = new Tree(1, 3);

        $tree1->withNorthNeighbor($tree2);

        $this->assertEquals(1, $tree1->viewNorth());
    }

    public function testFindsScenicViewEast(): void
    {
        $tree1 = new Tree(0, 5);
        $tree2 = new Tree(1, 1);
        $tree3 = new Tree(2, 2);

        $tree1->withEastNeighbor($tree2);
        $tree2->withEastNeighbor($tree3);

        $this->assertEquals(2, $tree1->viewEast());
    }

    public function testFindsScenicViewSouth(): void
    {
        $tree1 = new Tree(0, 5);
        $tree2 = new Tree(1, 3);
        $tree3 = new Tree(2, 5);
        $tree4 = new Tree(3, 3);

        $tree1->withSouthNeighbor($tree2);
        $tree2->withSouthNeighbor($tree3);
        $tree3->withSouthNeighbor($tree4);

        $this->assertEquals(2, $tree1->viewSouth());
    }

    public function testFindsScenicViewWest(): void
    {
        $tree1 = new Tree(0, 5);
        $tree2 = new Tree(1, 5);
        $tree3 = new Tree(2, 2);

        $tree1->withWestNeighbor($tree2);
        $tree2->withWestNeighbor($tree3);

        $this->assertEquals(1, $tree1->viewWest());
    }
}
