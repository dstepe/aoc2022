<?php

namespace Tests\Unit\Aoc\Day04;

use App\Aoc\Day04\AssignmentChecker;
use PHPUnit\Framework\TestCase;

class AssignmentCheckerTest extends TestCase
{
    /**
     * @dataProvider assignmentChecks
     */
    public function testChecksAssignments(string $pair, int $expected): void
    {
        $checker = new AssignmentChecker(new \ArrayIterator([$pair]));

        $checker->checkAssignments();

        $this->assertEquals($expected, $checker->containsCount());
    }

    public function assignmentChecks(): array
    {
        return [
            'not contains' => ['2-4,6-8', 0],
            'contains' => ['2-10,6-8', 1],
        ];
    }

    public function testCountsAllContainedAssignemtns(): void
    {
        $checker = new AssignmentChecker(new \ArrayIterator([
            '2-4,6-8',
            '2-10,6-8',
            '12-20,16-18',
            '22-24,26-28',
            '32-40,36-38',
            '51-55,50-60',
        ]));

        $checker->checkAssignments();

        $this->assertEquals(4, $checker->containsCount());
    }

    public function testCountsAllOverlappedAssignemtns(): void
    {
        $checker = new AssignmentChecker(new \ArrayIterator([
            '2-4,6-8',
            '2-10,6-8',
            '12-20,10-18',
            '22-24,20-28',
            '32-40,46-48',
            '51-55,60-65',
        ]));

        $checker->checkAssignments();

        $this->assertEquals(3, $checker->overlapsCount());
    }
}
