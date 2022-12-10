<?php

namespace App\Aoc\Day01;

class CalorieCounter
{
    private array $calorieSummary;
    private int $collector;
    private \Iterator $input;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
    }

    public function summarizeCalories(): void
    {
        $this->calorieSummary = [];
        $this->collector = 0;

        foreach ($this->input as $calories) {
            $this->addCalories($calories);
        }
    }

    public function findMaxLoad(int $top): int
    {
        rsort($this->calorieSummary);

        return array_sum(
            array_slice($this->calorieSummary, 0, $top)
        );
    }

    private function addCalories(string $calories): void
    {
        if (empty($calories)) {
            $this->calorieSummary[] = $this->collector;
            $this->collector = 0;
            return;
        }

        $this->collector += (int) $calories;
    }
}
