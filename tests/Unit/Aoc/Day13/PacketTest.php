<?php

namespace Tests\Unit\Aoc\Day13;

use App\Aoc\Day13\DistressSignal;
use App\Aoc\Day13\Packet;
use PHPUnit\Framework\TestCase;

class PacketTest extends TestCase
{
    public function testCreatesPacketFromLineOfIntegers(): void
    {
        $line = '[1,1,3,1,1]';

        $packet = Packet::fromLine($line);

        $this->assertEquals(1, $packet->value(0));
        $this->assertEquals(3, $packet->value(2));
    }

    public function testCreatesPacketFromLineWithArrays(): void
    {
        $line = '[[1],[2,3,4]]';

        $packet = Packet::fromLine($line);

        $this->assertEquals([1], $packet->value(0));
        $this->assertEquals([2, 3, 4], $packet->value(1));
    }

    public function testCreatesPacketFromLineWithBothIntegersAndArrays(): void
    {
        $line = '[[1],4]';

        $packet = Packet::fromLine($line);

        $this->assertEquals([1], $packet->value(0));
        $this->assertEquals(4, $packet->value(1));
    }

    public function testAssertsPacketWithValuesIsNotNull(): void
    {
        $packet = Packet::fromLine('[1]');

        $this->assertFalse($packet->isNull());
        $this->assertTrue($packet->isNotNull());
    }

    public function testHandlesNullLine(): void
    {
        $packet = Packet::fromLine('');

        $this->assertTrue($packet->isNull());
        $this->assertFalse($packet->isNotNull());
    }
}
