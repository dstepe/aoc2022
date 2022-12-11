<?php

namespace Tests\Unit\Aoc\Day10;

use App\Aoc\Day10\AddxInstruction;
use App\Aoc\Day10\Register;
use PHPUnit\Framework\TestCase;

class AddxInstructionTest extends TestCase
{
    public function testExeutesInsructionSteps(): void
    {
        $register = new Register();

        $instruction = new AddxInstruction(2);

        $instruction->modifyRegister($register);

        $instruction->tick();

        $this->assertEquals(1, $register->value());

        $instruction->tick();

        $this->assertEquals(3, $register->value());
    }

    public function testIndicatesCompleteStatus(): void
    {
        $register = new Register();

        $instruction = new AddxInstruction(2);

        $instruction->modifyRegister($register);

        $this->assertFalse($instruction->isComplete());

        $instruction->tick();

        $this->assertFalse($instruction->isComplete());

        $instruction->tick();

        $this->assertTrue($instruction->isComplete());
    }
}
