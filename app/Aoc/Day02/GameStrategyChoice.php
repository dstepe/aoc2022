<?php

namespace App\Aoc\Day02;

class GameStrategyChoice
{
    private \Iterator $input;

    private int $score;

    private $choiceValues = [
        'X' => 1, // Rock
        'Y' => 2, // Paper
        'Z' => 3, // Scissors
    ];

    private $beats = [
        'X' => 'C', // Rock beats scissors
        'Y' => 'A', // Paper beats rock
        'Z' => 'B', // Scissors beats paper
        'A' => 'Z', // Rock beats scissors
        'B' => 'X', // Paper beats rock
        'C' => 'Y', // Scissors beats paper
    ];

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
    }

    public function summarizeRounds(): void
    {
        $this->score = 0;

        foreach ($this->input as $round) {
            $this->score += $this->scoreRound(...explode(' ', $round));
        }
    }

    private function scoreRound(string $opponent, string $player): int
    {
        return $this->choiceValues[$player] + $this->earnedScore($opponent, $player);
    }

    private function earnedScore(string $opponent, string $player): int
    {
        if ($this->beats[$player] === $opponent) {
            return 6;
        }

        if ($this->beats[$opponent] === $player) {
            return 0;
        }

        return 3;
    }

    public function score(): int
    {
        return $this->score;
    }
}
