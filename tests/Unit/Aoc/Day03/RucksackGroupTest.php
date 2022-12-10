<?php

namespace Tests\Unit\Aoc\Day03;

use App\Aoc\Day03\Rucksack;
use App\Aoc\Day03\RucksackGroup;
use PHPUnit\Framework\TestCase;

class RucksackGroupTest extends TestCase
{
    public function testGetsBadgeForGroup(): void
    {
        $group = new RucksackGroup();

        $group->addRucksack(new Rucksack('vJrwpWtwJgWrhcsFMMfFFhFp'));
        $group->addRucksack(new Rucksack('jqHRNqRjqzjGDLGLrsFMfFZSrLrFZsSL'));
        $group->addRucksack(new Rucksack('PmmdzqPrVvPwwTWBwg'));

        $this->assertEquals('r', $group->getBadge());
    }
}
