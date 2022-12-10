<?php

namespace App\Aoc\Day07;

class File implements FileSystemObject
{
    private string $name;
    private int $size;

    public function __construct(string $name, int $size)
    {
        $this->name = $name;
        $this->size = $size;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function size(): int
    {
        return $this->size;
    }

    public function isDirectory(): bool
    {
        return false;
    }

    public function isFile(): bool
    {
        return true;
    }

    public function find(string $name): ?FileSystemObject
    {
        return null;
    }
}
