<?php

namespace App\Aoc\Day04;

class AssignmentChecker
{
    private \Iterator $input;

    private int $containsCount = 0;
    private int $overlapsCount = 0;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
    }

    public function checkAssignments(): void
    {
        foreach ($this->input as $assignmentPair) {
            $this->checkAssignmentPair($assignmentPair);
        }
    }

    public function containsCount(): int
    {
        return $this->containsCount;
    }

    public function overlapsCount():int
    {
        return $this->overlapsCount;
    }

    private function checkAssignmentPair(string $assignmentPair): void
    {
        $assignments = explode(',', $assignmentPair);

        $first = new SectionAssignment($assignments[0]);
        $second = new SectionAssignment($assignments[1]);

        if ($first->contains($second) || $second->contains($first)) {
            $this->containsCount++;
        }

        if ($first->overlaps($second) || $second->overlaps($first)) {
            $this->overlapsCount++;
        }
    }
}
