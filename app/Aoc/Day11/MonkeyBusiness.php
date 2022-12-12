<?php

namespace App\Aoc\Day11;

class MonkeyBusiness
{
    private \Iterator $input;

    private Troop $troop;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->troop = new Troop();
    }

    public function observeMonkeys(): void
    {
        $collectedNotes = [];
        foreach ($this->input as $note) {
            if (empty($note)) {
                $this->troop->addMonkeyFromNotes($collectedNotes);
                $collectedNotes = [];
                continue;
            }

            $collectedNotes[] = $note;
        }

        $this->troop->addMonkeyFromNotes($collectedNotes);
    }

    public function playRounds(int $rounds): void
    {
        for ($i = 0; $i < $rounds; $i++) {
            $this->troop->executeRound();
        }
    }

    public function monkeyBusinessLevel(): int
    {
        return $this->troop->monkeyBusinessLevel();
    }
}
