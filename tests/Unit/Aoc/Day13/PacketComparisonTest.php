<?php

namespace Tests\Unit\Aoc\Day13;

use App\Aoc\Day13\Packet;
use App\Aoc\Day13\PacketComparison;
use PHPUnit\Framework\TestCase;

class PacketComparisonTest extends TestCase
{
    /**
     * @dataProvider comparePacketsChecks
     */
    public function testProcessesPackets(string $left, string $right, bool $expected): void
    {
        $compare = new PacketComparison();

        $ordered = $compare->packetsAreInOrder(Packet::fromLine($left), Packet::fromLine($right));

        $this->assertEquals($expected, $ordered);
    }

    public function comparePacketsChecks(): array
    {
        return [
            'simple match' => ['[1,1,3,1,1]', '[1,1,5,1,1]', true],
            'int to array' => ['[[1],[2,3,4]]', '[[1],4]', true],
            'out of order' => ['[9]', '[[8,7,6]]', false],
            'left short' => ['[[4,4],4,4]', '[[4,4],4,4,4]', true],
            'right short' => ['[7,7,7,7]', '[7,7,7]', false],
            'left short empty' => ['[]', '[3]', true],
            'right short empty' => ['[[[]]]', '[[]]', false],
            'complicated out of order' => ['[1,[2,[3,[4,[5,6,7]]]],8,9]', '[1,[2,[3,[4,[5,6,0]]]],8,9]', false],
        ];
    }
}
