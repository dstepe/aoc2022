<?php

namespace Tests\Unit\Aoc\Day11;

use App\Aoc\Day11\Operation;
use App\Aoc\Day11\Troop;
use PHPUnit\Framework\TestCase;

class TroopTest extends TestCase
{
    public function testPreparesMonkeys(): void
    {
        $troop = new Troop();

        foreach ($this->testMonkeys() as $monkeyNotes) {
            $troop->addMonkeyFromNotes($monkeyNotes);
        }

        $expected = "Monkey 0: 79, 98\n" .
            "Monkey 1: 54, 65, 75, 74\n";

        $this->assertEquals($expected, $troop->list());
    }

    public function testExecutesRound():void
    {
        $troop = $this->makeTroop();

        $troop->executeRound();

        print $troop->list();

        $expected = "Monkey 0: 20, 23, 27, 26\n" .
            "Monkey 1: 2080, 25, 167, 207, 401, 1046\n" .
            "Monkey 2: \n" .
            "Monkey 3: \n";

        $this->assertEquals($expected, $troop->list());
    }

    public function testExecutesMultipleRounds():void
    {
        $troop = $this->makeTroop();

        for ($i = 0; $i < 20; $i++) {
            $troop->executeRound();
        }

        print $troop->list();

        $expected = "Monkey 0: 10, 12, 14, 26, 34\n" .
            "Monkey 1: 245, 93, 53, 199, 115\n" .
            "Monkey 2: \n" .
            "Monkey 3: \n";

        $this->assertEquals($expected, $troop->list());
    }

    public function testShowsMonkeyInspectedCountsAfterOneRound():void
    {
        Operation::reliefFactor(1);

        $troop = $this->makeTroop();

        $troop->executeRound();

        print $troop->inspectCounts();

        $expected = "Monkey 0 inspected items 2 times.\n" .
            "Monkey 1 inspected items 4 times.\n" .
            "Monkey 2 inspected items 3 times.\n" .
            "Monkey 3 inspected items 6 times.\n";

        $this->assertEquals($expected, $troop->inspectCounts());
    }

    public function testShowsMonkeyInspectedCountsAfterMultipleRounds():void
    {
        Operation::reliefFactor(1);

        $troop = $this->makeTroop();

        for ($i = 0; $i < 20; $i++) {
            $troop->executeRound();
        }

        print $troop->inspectCounts();

        $expected = "Monkey 0 inspected items 99 times.\n" .
            "Monkey 1 inspected items 97 times.\n" .
            "Monkey 2 inspected items 8 times.\n" .
            "Monkey 3 inspected items 103 times.\n";

        $this->assertEquals($expected, $troop->inspectCounts());
    }

    public function testCalculatesMonkeyBusiness():void
    {
        $troop = $this->makeTroop();

        for ($i = 0; $i < 20; $i++) {
            $troop->executeRound();
        }

        $this->assertEquals(10605, $troop->monkeyBusinessLevel());
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
                '  Test: divisible by 16',
                '    If true: throw to monkey 2',
                '    If false: throw to monkey 0',
            ],
        ];
    }

    private function makeTroop(): Troop
    {
        $troop = new Troop();

        foreach ($this->testMonkeysFullTroop() as $monkeyNotes) {
            $troop->addMonkeyFromNotes($monkeyNotes);
        }

        return $troop;
    }

    private function testMonkeysFullTroop(): array
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
