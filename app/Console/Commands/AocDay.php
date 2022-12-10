<?php

namespace App\Console\Commands;

use App\Aoc\InputIterator;
use Illuminate\Console\Command;

abstract class AocDay extends Command
{
    public const DAY_INPUT_FILE_FORMAT = 'input/day%02d_input.txt';

    protected $day = 1;

    protected function getDayInputFile(): \Iterator
    {
        $file = sprintf(self::DAY_INPUT_FILE_FORMAT, $this->day);

        if (empty($file)) {
            throw new \InvalidArgumentException('Missing "file" option');
        }

        return (new InputIterator($file))->rows();
    }
}
