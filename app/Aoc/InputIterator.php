<?php

namespace App\Aoc;

class InputIterator
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function rows(): \Iterator
    {
        $fileResource = fopen($this->fileName, 'rb');

        while (($line = fgets($fileResource)) !== false) {
            yield trim($line, "\n");
        }
    }
}
