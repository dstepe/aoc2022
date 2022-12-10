<?php

namespace Tests\Unit\Aoc\Day03;

use App\Aoc\Day03\Rucksack;
use PHPUnit\Framework\TestCase;

class RucksackTest extends TestCase
{
    public function testPutsContentsInCompartments(): void
    {
        $rucksack = new Rucksack('abcdef');

        $this->assertEquals(['a', 'b', 'c'], $rucksack->compartmentOne());
        $this->assertEquals(['d', 'e', 'f'], $rucksack->compartmentTwo());
    }

    public function testFindsCommonItems(): void
    {
        $rucksack = new Rucksack('abcdeb');

        $this->assertEquals(['b'], $rucksack->commonItems());
    }

    public function testDoesNotDuplicateCommonItems(): void
    {
        $rucksack = new Rucksack('abbdbb');

        $this->assertEquals(['b'], $rucksack->commonItems());
    }
}
