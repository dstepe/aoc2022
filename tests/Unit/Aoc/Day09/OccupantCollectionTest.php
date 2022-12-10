<?php

namespace Tests\Unit\Aoc\Day09;

use App\Aoc\Day09\Head;
use App\Aoc\Day09\Knot;
use App\Aoc\Day09\OccupantCollection;
use App\Aoc\Day09\Start;
use App\Aoc\Day09\Tail;
use PHPUnit\Framework\TestCase;

class OccupantCollectionTest extends TestCase
{
    /**
     * @dataProvider occupantMarkerChecks
     */
    public function testShowsCorrectOccupantMarker(array $occupants, string $expected): void
    {
        $collection = new OccupantCollection($occupants);

        $this->assertEquals($expected, $collection->occupantMarker());
    }

    public function occupantMarkerChecks(): array
    {
        return [
            'no occupants' => [[], OccupantCollection::EMPTY_MARKER],
            'start' => [[Knot::start()], Knot::START_MARKER],
            'head' => [[Knot::head()], Knot::HEAD_MARKER],
            'tail' => [[Knot::tail()], Knot::TAIL_MARKER],
            'all' => [[Knot::tail(), Knot::start(), Knot::head()], Knot::HEAD_MARKER],
            'head, tail' => [[Knot::tail(), Knot::head()], Knot::HEAD_MARKER],
        ];
    }

    public function testRemovesGivenOccupant(): void
    {
        $tail = Knot::tail();
        $collection = new OccupantCollection([Knot::start(), $tail]);

        $collection->remove($tail);

        $this->assertCount(1, $collection);
    }
}
