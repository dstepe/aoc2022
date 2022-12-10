<?php

namespace App\Aoc\Day09;

class Knot
{
    public const START_MARKER = 's';
    public const HEAD_MARKER = 'H';
    public const TAIL_MARKER = '9';

    protected string $occupantMarker;

    protected int $order = 10;

    protected bool $visits = false;

    protected ?Knot $follows;

    protected ?Position $position;

    private function __construct(int $place, string $marker, bool $visits = false)
    {
        $this->order = $place;
        $this->occupantMarker = $marker;
        $this->visits = $visits;
    }

    public static function start(): self
    {
        return new self(11, 's', true);
    }

    public static function head(): self
    {
        return new self(1, 'H');
    }

    public static function tail(): self
    {
        return new self(10, '9', true);
    }

    public static function knot(int $position): self
    {
        return new self($position + 1, (string) $position);
    }

    public function follows(Knot $knot): void
    {
        $this->follows = $knot;
    }

    public function marker(): string
    {
        return $this->occupantMarker;
    }

    public function order(): int
    {
        return $this->order;
    }

    public function shouldVisit(): bool
    {
        return $this->visits;
    }

    public function enters(Position $position): void
    {
        $this->position = $position;
        $position->arrives($this);
    }

    public function leaves(Position $position): void
    {
        $this->position = null;
        $position->leaves($this);
    }

    public function position(): Position
    {
        if (empty($this->position)) {
            throw new \InvalidArgumentException('Knot has no position');
        }

        return $this->position;
    }
}
