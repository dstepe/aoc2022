<?php

namespace App\Aoc\Day08;

class Tree
{
    private int $position;
    private int $height;

    private Tree $northNeighbor;
    private Tree $eastNeighbor;
    private Tree $southNeighbor;
    private Tree $westNeighbor;

    public function __construct(int $position, int $height)
    {
        $this->position = $position;
        $this->height = $height;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function withNorthNeighbor(Tree $tree): void
    {
        $this->northNeighbor = $tree;
    }

    public function withEastNeighbor(Tree $tree): void
    {
        $this->eastNeighbor = $tree;
    }

    public function withSouthNeighbor(Tree $tree): void
    {
        $this->southNeighbor = $tree;
    }

    public function withWestNeighbor(Tree $tree): void
    {
        $this->westNeighbor = $tree;
    }

    public function isVisible(): bool
    {
        if ($this->canSeeNorth()) {
            return true;
        }

        if ($this->canSeeEast()) {
            return true;
        }

        if ($this->canSeeSouth()) {
            return true;
        }

        if ($this->canSeeWest()) {
            return true;
        }

        return false;
    }

    public function canSeeNorth(): bool
    {
        if (empty($this->northNeighbor)) {
            return true;
        }

        return $this->northNeighbor->isLowerThanNorth($this);
    }

    public function isLowerThanNorth(Tree $tree): bool
    {
        if ($this->height >= $tree->height()) {
            return false;
        }

        if (empty($this->northNeighbor)) {
            return true;
        }

        return $this->northNeighbor->isLowerThanNorth($tree);
    }

    public function canSeeEast(): bool
    {
        if (empty($this->eastNeighbor)) {
            return true;
        }

        return $this->eastNeighbor->isLowerThanEast($this);
    }

    public function isLowerThanEast(Tree $tree): bool
    {
        if ($this->height >= $tree->height()) {
            return false;
        }

        if (empty($this->eastNeighbor)) {
            return true;
        }

        return $this->eastNeighbor->isLowerThanEast($tree);
    }

    public function canSeeSouth(): bool
    {
        if (empty($this->southNeighbor)) {
            return true;
        }

        return $this->southNeighbor->isLowerThanSouth($this);
    }

    public function isLowerThanSouth(Tree $tree): bool
    {
        if ($this->height >= $tree->height()) {
            return false;
        }

        if (empty($this->southNeighbor)) {
            return true;
        }

        return $this->southNeighbor->isLowerThanSouth($tree);
    }

    public function canSeeWest(): bool
    {
        if (empty($this->westNeighbor)) {
            return true;
        }

        return $this->westNeighbor->isLowerThanWest($this);
    }

    public function isLowerThanWest(Tree $tree): bool
    {
        if ($this->height >= $tree->height()) {
            return false;
        }

        if (empty($this->westNeighbor)) {
            return true;
        }

        return $this->westNeighbor->isLowerThanWest($tree);
    }

    public function scenicScore(): int
    {
        $n = $this->viewNorth();
        $e = $this->viewEast();
        $s = $this->viewSouth();
        $w = $this->viewWest();

        return $n * $e * $s * $w;
    }

    public function viewNorth(): int
    {
        if (empty($this->northNeighbor)) {
            return 0;
        }

        return $this->northNeighbor->checkNeighborViewNorth($this);
    }

    private function checkNeighborViewNorth(Tree $tree, int $view = 0): int
    {
        $view++;

        if ($this->height() >= $tree->height()) {
            return $view;
        }

        if (empty($this->northNeighbor)) {
            return $view;
        }

        return $this->northNeighbor->checkNeighborViewNorth($tree, $view);
    }

    public function viewEast(): int
    {
        if (empty($this->eastNeighbor)) {
            return 0;
        }

        return $this->eastNeighbor->checkNeighborViewEast($this);
    }

    private function checkNeighborViewEast(Tree $tree, int $view = 0): int
    {
        $view++;

        if ($this->height() >= $tree->height()) {
            return $view;
        }

        if (empty($this->eastNeighbor)) {
            return $view;
        }

        return $this->eastNeighbor->checkNeighborViewEast($tree, $view);
    }

    public function viewSouth(): int
    {
        if (empty($this->southNeighbor)) {
            return 0;
        }

        return $this->southNeighbor->checkNeighborViewSouth($this);
    }

    private function checkNeighborViewSouth(Tree $tree, int $view = 0): int
    {
        $view++;

        if ($this->height() >= $tree->height()) {
            return $view;
        }

        if (empty($this->southNeighbor)) {
            return $view;
        }

        return $this->southNeighbor->checkNeighborViewSouth($tree, $view);
    }

    public function viewWest(): int
    {
        if (empty($this->westNeighbor)) {
            return 0;
        }

        return $this->westNeighbor->checkNeighborViewWest($this);
    }

    private function checkNeighborViewWest(Tree $tree, int $view = 0): int
    {
        $view++;

        if ($this->height() >= $tree->height()) {
            return $view;
        }

        if (empty($this->westNeighbor)) {
            return $view;
        }

        return $this->westNeighbor->checkNeighborViewWest($tree, $view);
    }
}
