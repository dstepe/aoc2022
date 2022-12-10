<?php

namespace Tests\Unit\Aoc\Day03;

use App\Aoc\Day03\RucksackReorganization;
use PHPUnit\Framework\TestCase;

class RucksackReorganizationTest extends TestCase
{
    /**
     * @dataProvider prioritizationChecks
     */
    public function testPrioritizesCommonItems(string $contents, int $expected): void
    {
        $reorg = new RucksackReorganization(new \ArrayIterator([$contents]));

        $reorg->searchRucksacks();

        $this->assertEquals($expected, $reorg->totalPriority());
    }

    public function prioritizationChecks(): array
    {
        return [
            'none' => ['abcdef', 0],
            'a' => ['abcdaf', 1],
            'A' => ['AbcdAf', 27],
            'aA' => ['AacdAa', 28],
            'sack 1' => ['vJrwpWtwJgWrhcsFMMfFFhFp', 16],
            'sack 2' => ['jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL', 38],
            'sack 3' => ['PmmdzqPrVvPwwTWBwg', 42],
            'sack 4' => ['wMqvLMZHhHMvwLHjbvcjnnSBnvTQFn', 22],
            'sack 5' => ['ttgJtRGJQctTZtZT', 20],
            'sack 6' => ['CrZsJsPPZsGzwwsLwLmpwMDw', 19],
        ];
    }
}
