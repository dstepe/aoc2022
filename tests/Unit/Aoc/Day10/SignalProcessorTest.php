<?php

namespace Tests\Unit\Aoc\Day10;

use App\Aoc\Day10\Cpu;
use App\Aoc\Day10\Instruction;
use App\Aoc\Day10\SignalProcessor;
use PHPUnit\Framework\TestCase;

class SignalProcessorTest extends TestCase
{
    public function testSendsInstructionsToCpu(): void
    {
        $cpu = $this->createMock(Cpu::class);

        $cpu->expects($this->once())->method('execute')
            ->with($this->callback(function (Instruction $instruction) {
                $this->assertEquals('addx', $instruction->instruction());
                $this->assertEquals([1], $instruction->arguments());
                return true;
            }));

        $processor = new SignalProcessor($cpu);

        $processor->process('addx 1');
    }
}
