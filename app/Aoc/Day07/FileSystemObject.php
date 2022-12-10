<?php

namespace App\Aoc\Day07;

interface FileSystemObject
{
    public function name(): string;

    public function size(): int;

    public function isDirectory(): bool;

    public function isFile(): bool;

    public function find(string $name): ?self;
}
