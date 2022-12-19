<?php

namespace Tests\Unit\Aoc\Day14;

use App\Aoc\Day14\Scanner;
use PHPUnit\Framework\TestCase;

class ScannerTest extends TestCase
{
    public function testProcessesScanLines(): void
    {
        $scanner = new Scanner();

        $scanner->processRockPath('498,4 -> 498,6 -> 496,6');

        $paths = $scanner->rockPaths();

        $this->assertCount(1, $paths);

        $path = $paths->first();

        $this->assertCount(3, $path);
    }
}
