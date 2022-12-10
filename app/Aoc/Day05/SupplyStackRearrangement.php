<?php

namespace App\Aoc\Day05;

class SupplyStackRearrangement
{
    public const SINGLE_MODE = 9000;
    public const MULTI_MODE = 9001;

    private \Iterator $input;

    private int $mode = self::SINGLE_MODE;

    /**
     * @var SupplyStack[]
     */
    private array $stacks = [];

    public function __construct(\Iterator $input)
    {
        $this->input = $input;
    }

    public function mode(int $mode): void
    {
        $this->mode = $mode;
    }

    public function arrangeCrates(): void
    {
        $readMode = 'manifest';

        $manifest = [];
        foreach ($this->input as $line) {
            if (empty($line)) {
                $readMode = 'moves';
                $this->makeStacksFromManifest($manifest);
                continue;
            }

            if ($readMode === 'manifest') {
                $manifest[] = $line;
                continue;
            }

            $this->processMove($line);
        }

    }

    public function topCrates(): string
    {
        return array_reduce($this->stacks, function(string $c, SupplyStack $stack) {
            $c .= $stack->topCrate()->label();
            return $c;
        }, '');
    }

    private function makeStacksFromManifest(array $manifest): void
    {
        $this->stacks = [];

        // Reverse so we start at the bottom of the stack
        $manifest = array_reverse($manifest);

        // Shift off the stack labels for now
        array_shift($manifest);

        while ($level = array_shift($manifest)) {
            $level = array_map('trim', str_split($level, 4));
            foreach ($level as $i => $iValue) {
                if (empty($iValue)) {
                    continue;
                }
                $this->addCrateToStack($i, new SupplyCrate(str_replace(['[', ']'], [], $iValue)));
            }
        }
    }

    private function addCrateToStack(int $stack, SupplyCrate $crate): void
    {
        if (empty($this->stacks[$stack])) {
            $this->stacks[$stack] = new SupplyStack();
        }

        $this->stacks[$stack]->pushCrate($crate);
    }

    private function processMove(string $instruction): void
    {
        $parts = explode(' ', $instruction);

        $move = $parts[1];
        $from = $parts[3] - 1;
        $to = $parts[5] - 1;

        try {
            $this->stacks[$from]->move($move, $this->mode)->toStack($this->stacks[$to]);
        } catch (\Throwable $e) {
            print "Failed to process move: $instruction\n";
            printf("Moving %s from %s to %s\n", $move, $from, $to);
            printf("From stack had %s, to stack had %s\n", $this->stacks[$from]->count(), $this->stacks[$to]->count());
        }
    }
}
