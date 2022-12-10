<?php

namespace App\Aoc\Day02;

class GameStrategyEnd
{
    public const OPPONENT_ROCK = 'A';
    public const OPPONENT_PAPER = 'B';
    public const OPPONENT_SCISSORS = 'C';
    public const PLAYER_ROCK = 'X';
    public const PLAYER_PAPER = 'Y';
    public const PLAYER_SCISSORS = 'Z';
    public const ROUND_LOSE = 'X';
    public const ROUND_DRAW = 'Y';
    public const ROUND_WIN = 'Z';

    private \Iterator $input;

    private int $score;

    private $roundValues = [
        self::ROUND_LOSE => 0,
        self::ROUND_DRAW => 3,
        self::ROUND_WIN => 6,
    ];

    private $choiceValues = [
        self::PLAYER_ROCK => 1, // Rock
        self::PLAYER_PAPER => 2, // Paper
        self::PLAYER_SCISSORS => 3, // Scissors
    ];

    private $loseRound = [
        self::OPPONENT_ROCK => self::PLAYER_SCISSORS, // Rock beats scissors
        self::OPPONENT_PAPER => self::PLAYER_ROCK, // Paper beats rock
        self::OPPONENT_SCISSORS => self::PLAYER_PAPER, // Scissors beats paper
    ];

    private $winRound = [
        self::OPPONENT_ROCK => self::PLAYER_PAPER, // Rock loses paper
        self::OPPONENT_PAPER => self::PLAYER_SCISSORS, // Paper loses scissors
        self::OPPONENT_SCISSORS => self::PLAYER_ROCK, // Scissors loses rock
    ];

    private $ties = [
        self::OPPONENT_ROCK => self::PLAYER_ROCK, // Rock ties rock
        self::OPPONENT_PAPER => self::PLAYER_PAPER, // Paper ties paper
        self::OPPONENT_SCISSORS => self::PLAYER_SCISSORS // Scissors ties scissors
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

    private function scoreRound(string $opponent, string $outcome): int
    {
        $player = $this->playerChoice($opponent, $outcome);

        return $this->choiceValues[$player] + $this->roundValues[$outcome];
    }

    private function playerChoice(string $opponent, string $outcome): string
    {
        if ($outcome === self::ROUND_LOSE) {
            return $this->loseRound[$opponent];
        }

        if ($outcome === self::ROUND_WIN) {
            return $this->winRound[$opponent];
        }

        return $this->ties[$opponent];
    }

    public function score(): int
    {
        return $this->score;
    }
}
