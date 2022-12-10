<?php

namespace App\Aoc\Day08;

class TreeRow
{
    private int $position;
    private array $trees = [];

    public function __construct(int $position)
    {
        $this->position = $position;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function addTree(int $height): Tree
    {
        $tree = new Tree(count($this->trees), $height);
        $this->trees[] = $tree;
        return $tree;
    }

    public function treeAt(int $position): Tree
    {
        return $this->trees[$position];
    }

    public function map(): string
    {
        return array_reduce($this->trees, function (string $c, Tree $tree) {
            $c .= $tree->height();
            return $c;
        }, '');
    }

    public function isEmpty(): bool
    {
        return empty($this->trees);
    }

    public function visible(): int
    {
        return array_reduce($this->trees, function (int $c, Tree $tree) {
            if ($tree->isVisible()) {
                $c++;
            }

            return $c;
        }, 0);
    }

    public function visibleMap(): string
    {
        return array_reduce($this->trees, function (string $c, Tree $tree) {
            $c .= $tree->isVisible() ? 'X' : '-';
            return $c;
        }, '');
    }

    public function highestScenicScore(): int
    {
        return array_reduce($this->trees, function (int $c, Tree $tree) {
            $score = $tree->scenicScore();
            return max($score, $c);
        }, 0);
    }
}
