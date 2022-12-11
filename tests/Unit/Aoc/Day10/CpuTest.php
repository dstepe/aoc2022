<?php

namespace Tests\Unit\Aoc\Day10;

use App\Aoc\Day10\AddxInstruction;
use App\Aoc\Day10\Cpu;
use App\Aoc\Day10\NoopInstruction;
use App\Aoc\Day10\Register;
use PHPUnit\Framework\TestCase;

class CpuTest extends TestCase
{
    public function testProcessesInstructions(): void
    {
        $registry = new Register();
        $cpu = new Cpu($registry);

        $cpu->execute(new NoopInstruction());
        $cpu->tick(1);
        $this->assertEquals(1, $registry->value());

        $cpu->execute(new AddxInstruction(3));
        $cpu->tick(2);
        $this->assertEquals(1, $registry->value());

        $cpu->execute(new AddxInstruction(-1));
        $cpu->tick(3);
        $this->assertEquals(4, $registry->value());

        $cpu->tick(4);
        $this->assertEquals(3, $registry->value());
    }
}
