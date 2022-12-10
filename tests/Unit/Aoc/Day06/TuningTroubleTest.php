<?php

namespace Tests\Unit\Aoc\Day06;

use App\Aoc\Day06\TuningTrouble;
use PHPUnit\Framework\TestCase;

class TuningTroubleTest extends TestCase
{
    /**
     * @dataProvider seekStartOfPacketChecks
     */
    public function testSeeksStartOfPacket(string $buffer, int $expected): void
    {
        $tuner = new TuningTrouble(new \ArrayIterator([$buffer]));

        $tuner->seek();

        $this->assertEquals($expected, $tuner->startOfPacket());
    }

    public function seekStartOfPacketChecks(): array
    {
        return [
            ['bvwbjplbgvbhsrlpgdmjqwftvncz',5],
            ['nppdvjthqldpwncqszvftbrmjlhg',6],
            ['nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg',10],
            ['zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw',11],
        ];
    }

    /**
     * @dataProvider seekStartOfMessageChecks
     */
    public function testSeeksStartOfMessage(string $buffer, int $expected): void
    {
        $tuner = new TuningTrouble(new \ArrayIterator([$buffer]));

        $tuner->seek();

        $this->assertEquals($expected, $tuner->startOfMessage());
    }

    public function seekStartOfMessageChecks(): array
    {
        return [
            ['mjqjpqmgbljsphdztnvjfqwrcgsmlb', 19],
            ['bvwbjplbgvbhsrlpgdmjqwftvncz', 23],
            ['nppdvjthqldpwncqszvftbrmjlhg', 23],
            ['nznrnfrfntjfmvfwmzdfjlvtqnbhcprsg', 29],
            ['zcfzfwzzqfrljwzlrfnpqdbhtmscgvjw', 26],
        ];
    }
}
