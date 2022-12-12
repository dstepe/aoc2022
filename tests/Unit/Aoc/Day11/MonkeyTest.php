<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Monkey;
use App\Aoc\Day11\Troop;
use PHPUnit\Framework\TestCase;

class MonkeyTest extends TestCase
{
    public function testCreatesFromNotes(): void
    {
        $notes = [
            'Monkey 0:',
            '  Starting items: 79, 98',
            '  Operation: new = old * 19',
            '  Test: divisible by 23',
            '    If true: throw to monkey 2',
            '    If false: throw to monkey 3',
        ];

        $monkey = Monkey::fromNotes($notes);

        $this->assertCount(2, $monkey->items());
    }
    public function testExecutesTurn(): void
    {
        $troop = $this->makeTroop();

        $monkey = $troop->getMonkey(0);

        $monkey->executeTurn();

        $this->assertCount(0,$monkey->items());
        $this->assertCount(3, $troop->getMonkey(3)->items());
    }

    private function makeTroop(): Troop
    {
        $troop = new Troop();

        foreach ($this->testMonkeys() as $monkeyNotes) {
            $troop->addMonkeyFromNotes($monkeyNotes);
        }

        return $troop;
    }

    private function testMonkeys(): array
    {
        return [
            [
                'Monkey 0:',
                '  Starting items: 79, 98',
                '  Operation: new = old * 19',
                '  Test: divisible by 23',
                '    If true: throw to monkey 2',
                '    If false: throw to monkey 3',
            ],
            [
                'Monkey 1:',
                '  Starting items: 54, 65, 75, 74',
                '  Operation: new = old + 6',
                '  Test: divisible by 19',
                '    If true: throw to monkey 2',
                '    If false: throw to monkey 0',
            ],
            [
                'Monkey 2:',
                '  Starting items: 79, 60, 97',
                '  Operation: new = old * old',
                '  Test: divisible by 13',
                '    If true: throw to monkey 1',
                '    If false: throw to monkey 3',
            ],
            [
                'Monkey 3:',
                '  Starting items: 74',
                '  Operation: new = old + 3',
                '  Test: divisible by 17',
                '    If true: throw to monkey 0',
                '    If false: throw to monkey 1',
            ]
        ];
    }
}
