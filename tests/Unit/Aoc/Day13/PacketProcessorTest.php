<?php

namespace Tests\Unit\Aoc\Day13;

use App\Aoc\Day13\Packet;
use App\Aoc\Day13\PacketListener;
use App\Aoc\Day13\PacketProcessor;
use PHPUnit\Framework\TestCase;

class PacketProcessorTest extends TestCase
{
    /**
     * @dataProvider processesPacketsChecks
     */
    public function testProcessesPackets(string $left, string $right, bool $ordered): void
    {
        $listener = $this->createMock(PacketListener::class);
        $listener->expects($this->once())->method($ordered ? 'rightOrder' : 'wrongOrder');
        $listener->expects($this->never())->method($ordered ? 'wrongOrder' : 'rightOrder');

        $processor = new PacketProcessor($listener);

        $processor->process(Packet::fromLine($left));
        $processor->process(Packet::fromLine($right));
    }

    public function processesPacketsChecks(): array
    {
        return [
            'simple match' => ['[1,1,3,1,1]', '[1,1,5,1,1]', true],
            'int to array' => ['[[1],[2,3,4]]', '[[1],4]', true],
            'right short' => ['[7,7,7,7]', '[7,7,7]', false],
        ];
    }

    public function testProcessesPacketPairs(): void
    {
        $listener = $this->createMock(PacketListener::class);
        $listener->expects($this->exactly(2))->method('rightOrder');
        $listener->expects($this->once())->method('wrongOrder');

        $processor = new PacketProcessor($listener);

        $processor->process(Packet::fromLine('[1,1,3,1,1]'));
        $processor->process(Packet::fromLine('[1,1,5,1,1]'));
        $processor->process(Packet::fromLine(''));
        $processor->process(Packet::fromLine('[[1],[2,3,4]]'));
        $processor->process(Packet::fromLine('[[1],4]'));
        $processor->process(Packet::fromLine(''));
        $processor->process(Packet::fromLine('[7,7,7,7]'));
        $processor->process(Packet::fromLine('[7,7,7]'));
    }
}
