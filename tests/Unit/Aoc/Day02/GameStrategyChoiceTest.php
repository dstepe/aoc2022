<?php

namespace Tests\Unit\Aoc\Day02;

use App\Aoc\Day02\GameStrategyChoice;
use PHPUnit\Framework\TestCase;

class GameStrategyChoiceTest extends TestCase
{
    /**
     * @dataProvider roundChecks
     */
    public function testScoresRound(string $round, int $expected): void
    {
        $strategy = new GameStrategyChoice(new \ArrayIterator([$round]));
        $strategy->summarizeRounds();

        $this->assertEquals($expected, $strategy->score());
    }

    public function roundChecks(): array
    {
        return [
            'rock rock' => ['A X', 4],
            'rock paper' => ['A Y', 8],
            'rock scissors' => ['A Z', 3],
            'paper rock' => ['B X', 1],
            'paper paper' => ['B Y', 5],
            'paper scissors' => ['B Z', 9],
            'scissors rock' => ['C X', 7],
            'scissors paper' => ['C Y', 2],
            'scissors scissors' => ['C Z', 6],
        ];
    }

    public function testAddsAllScores(): void
    {
//        'X' => 1, // Rock
//        'Y' => 2, // Paper
//        'Z' => 3, // Scissors
//        'A' => 1, // Rock
//        'B' => 2, // Paper
//        'C' => 3, // Scissors

        $strategy = new GameStrategyChoice(new \ArrayIterator([
            'C Z', // 3 3 3 6
            'C Z', // 3 3 3 6
            'C Y', // 3 2 0 2
            'C Z', // 3 3 3 6
            'C Z', // 3 3 3 6
            'C Z', // 3 3 3 6
            'A X', // 1 1 3 4
            'A X', // 1 1 3 4
            'C X', // 3 1 0 1
            'C X', // 3 1 0 1
        ]));

        $strategy->summarizeRounds();

        $this->assertEquals(42, $strategy->score());
    }
}
