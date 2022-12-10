<?php

namespace Tests\Unit\Aoc\Day09;

use App\Aoc\Day09\Head;
use App\Aoc\Day09\Knot;
use App\Aoc\Day09\Position;
use App\Aoc\Day09\Start;
use App\Aoc\Day09\Tail;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    public function testShowsCorrectOccupantMarkerForPositionWithNoOccupants(): void
    {
        $position = Position::makePosition();

        $this->assertEquals(Position::EMPTY_MARKER, $position->occupantMarker());
    }

    public function testShowsCorrectOccupantMarkerForPositionWithStartOccupant(): void
    {
        $position = Position::makePosition()->withOccupants(Knot::start());

        $this->assertEquals(Knot::START_MARKER, $position->occupantMarker());
    }

    public function testShowsCorrectVisitedMarkerForPositionWhenNotVisited(): void
    {
        $position = Position::makePosition();

        $this->assertEquals(Position::NOT_VISITED_MARKER, $position->visitedMarker());
    }

    public function testShowsCorrectVisitedMarkerForPositionWithStartOccupant(): void
    {
        $position = Position::makePosition()->withOccupants(Knot::start());

        $this->assertEquals(Knot::START_MARKER, $position->visitedMarker());
    }

    public function testShowsCorrectVisitedMarkerForPositionWithHeadOccupant(): void
    {
        $position = Position::makePosition()->withOccupants(Knot::head());

        $this->assertEquals(Position::NOT_VISITED_MARKER, $position->visitedMarker());
    }

    public function testShowsCorrectVisitedMarkerForPositionWithTailOccupant(): void
    {
        $position = Position::makePosition()->withOccupants(Knot::tail());

        $this->assertEquals(Position::VISITED_MARKER, $position->visitedMarker());
    }

    public function testShowsCorrectVisitedMarkerForPositionWithStartAndTailOccupant(): void
    {
        $position = Position::makePosition()->withOccupants(Knot::start(), Knot::tail());

        $this->assertEquals(Knot::START_MARKER, $position->visitedMarker());
    }

    public function testShowsCorrectOccupantMarkerWhenOccoupantArrives(): void
    {
        $position = Position::makePosition();

        $position->arrives(Knot::head());

        $this->assertEquals(Knot::HEAD_MARKER, $position->occupantMarker());
    }

    public function testShowsCorrectVisitedMarkerWhenOccupantArrives(): void
    {
        $position = Position::makePosition();

        $position->arrives(Knot::tail());

        $this->assertEquals(Position::VISITED_MARKER, $position->visitedMarker());
    }

    public function testShowsCorrectOccupantMarkerWhenOccupantLeaves(): void
    {
        $tail = Knot::tail();

        $position = Position::makePosition()->withOccupants($tail);

        $position->leaves($tail);

        $this->assertEquals(Position::EMPTY_MARKER, $position->occupantMarker());
    }
}
