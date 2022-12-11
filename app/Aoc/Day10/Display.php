<?php

namespace App\Aoc\Day10;

use Illuminate\Support\Collection;

class Display implements ClockListener
{
    private Register $register;

    private Collection $rows;

    private Collection $drawingRow;

    private int $currentRow = 0;
    private int $currentPosition = 0;

    public function __construct(Register $register)
    {
        $this->register = $register;
        $this->initialize();
    }

    public function tick(int $cycle): void
    {
        // get register value
        // give value to current row
        // if value in current draw range, draw pixel
        $this->draw();
        $this->advancePosition();
    }

    public function display(): string
    {
        return $this->rows->reduce(function (string $c, Collection $row) {
            $c .= $row->reduce(function (string $d, Pixel $pixel) {
                $d .= $pixel->value();
                return $d;
            }, '') . "\n";
            return $c;
        }, '');
    }

    private function initialize(): void
    {
        // each pixel gets a row (1 - 6) and position (1 - 40)
        $this->rows = new Collection();
        for ($i = 0; $i < 6; $i++) {
            $row = new Collection();
            for ($j = 0; $j < 40; $j++) {
                $row->add(new Pixel());
            }
            $this->rows->add($row);
        }

        $this->drawingRow = $this->rows->first();
    }

    private function draw(): void
    {
        if ($this->inSprite()) {
            /** @var Pixel $pixel */
            $pixel = $this->drawingRow->get($this->currentPosition);

            $pixel->lit();
        }
    }

    private function inSprite(): bool
    {
        // 0 based row
        $drawingPosition = $this->currentPosition;

        $spriteCenter = $this->register->value();
        $spriteStart = $spriteCenter - 1;
        $spriteEnd = $spriteCenter + 1;

        if ($drawingPosition >= $spriteStart && $drawingPosition <= $spriteEnd) {
            return true;
        }

        return false;
    }

    private function advancePosition(): void
    {
        $this->currentPosition++;
        if ($this->currentPosition < $this->drawingRow->count()) {
            return;
        }

        $this->currentPosition = 0;
        $this->currentRow++;

        if ($this->currentRow >= $this->rows->count()) {
            $this->currentRow = 0;
        }

        $this->drawingRow = $this->rows->get($this->currentRow);
    }
}
