<?php

namespace Tests\Unit\Aoc\Day04;

use App\Aoc\Day04\SectionAssignment;
use PHPUnit\Framework\TestCase;

class SectionAssignmentTest extends TestCase
{
    public function testParsesRange(): void
    {
        $assignment = new SectionAssignment('2-5');

        $this->assertEquals(2, $assignment->rangeStart());
        $this->assertEquals(5, $assignment->rangeEnd());
    }

    /**
     * @dataProvider assignmentContainsChecks
     */
    public function testAssertContainsOtherAssignment(string $range, bool $expected): void
    {
        $assignment = new SectionAssignment('234-255');

        $partner = new SectionAssignment($range);

        $this->assertEquals($expected, $assignment->contains($partner));
    }

    public function assignmentContainsChecks(): array
    {
        return [
            'outside' => ['10-20', false],
            'front overlap' => ['230-240', false],
            'end overlap' => ['250-260', false],
            'within' => ['240-245', true],
        ];
    }

    /**
     * @dataProvider assignmentOverlapsChecks
     */
    public function testAssertOverlapsOtherAssignment(string $range, bool $expected): void
    {
        $assignment = new SectionAssignment('234-255');

        $partner = new SectionAssignment($range);

        $this->assertEquals($expected, $assignment->overlaps($partner));
    }

    public function assignmentOverlapsChecks(): array
    {
        return [
            'outside' => ['10-20', false],
            'front overlap' => ['230-240', true],
            'end overlap' => ['250-260', true],
            'within' => ['240-245', true],
        ];
    }
}
