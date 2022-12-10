<?php

namespace Tests\Unit\Aoc\Day02;

use App\Aoc\Day02\GameStrategyEnd;
use PHPUnit\Framework\TestCase;

class GameStrategyEndTest extends TestCase
{
    /**
     * @dataProvider roundChecks
     */
    public function testScoresRound(string $round, int $expected): void
    {
        $strategy = new GameStrategyEnd(new \ArrayIterator([$round]));
        $strategy->summarizeRounds();

        $this->assertEquals($expected, $strategy->score());
    }

    public function roundChecks(): array
    {
        return [
            'rock lose' => ['A X', 3],
            'rock draw' => ['A Y', 4],
            'rock win' => ['A Z', 8],
            'paper lose' => ['B X', 1],
            'paper draw' => ['B Y', 5],
            'paper win' => ['B Z', 9],
            'scissors lose' => ['C X', 2],
            'scissors draw' => ['C Y', 6],
            'scissors win' => ['C Z', 7],
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

        $strategy = new GameStrategyEnd(new \ArrayIterator([
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
