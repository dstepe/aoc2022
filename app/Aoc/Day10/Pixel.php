<?php

namespace App\Aoc\Day10;

class Pixel
{
    public const LIT = '#';
    public const DARK = '.';

    private bool $lit = false;

    public function value(): string
    {
        return $this->lit ? self::LIT : self::DARK;
    }

    public function lit(): void
    {
        $this->lit = true;
    }
}
