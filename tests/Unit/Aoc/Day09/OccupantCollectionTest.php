<?php

namespace Tests\Unit\Aoc\Day09;

use App\Aoc\Day09\Head;
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
            'start' => [[new Start()], Start::MARKER],
            'head' => [[new Head()], Head::MARKER],
            'tail' => [[new Tail()], Tail::MARKER],
            'all' => [[new Tail(), new Start(), new Head()], Start::MARKER],
            'head, tail' => [[new Tail(), new Head()], Head::MARKER],
        ];
    }

    public function testRemovesGivenOccupant(): void
    {
        $tail = new Tail();
        $collection = new OccupantCollection([new Start(), $tail]);

        $collection->remove($tail);

        $this->assertCount(1, $collection);
    }
}
