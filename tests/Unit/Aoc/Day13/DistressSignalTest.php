<?php

namespace Tests\Unit\Aoc\Day13;

use App\Aoc\Day13\DistressSignal;
use PHPUnit\Framework\TestCase;

class DistressSignalTest extends TestCase
{
    public function testProcessesSignals(): void
    {
        $processor = new DistressSignal($this->sampleSignals());

        $processor->processSignals();

        $this->assertEquals(13, $processor->correctPacketIndicator());
    }

    private function sampleSignals(): \ArrayIterator
    {
        return new \ArrayIterator([
            '[1,1,3,1,1]',
            '[1,1,5,1,1]',
            '',
            '[[1],[2,3,4]]',
            '[[1],4]',
            '',
            '[9]',
            '[[8,7,6]]',
            '',
            '[[4,4],4,4]',
            '[[4,4],4,4,4]',
            '',
            '[7,7,7,7]',
            '[7,7,7]',
            '',
            '[]',
            '[3]',
            '',
            '[[[]]]',
            '[[]]',
            '',
            '[1,[2,[3,[4,[5,6,7]]]],8,9]',
            '[1,[2,[3,[4,[5,6,0]]]],8,9]',
        ]);
    }
}
