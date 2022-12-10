<?php

namespace App\Aoc\Day08;

class Forest
{
    /** @var TreeRow[] */
    private array $rows = [];

    private TreeRow $currentRow;

    public function addRow(string $row): void
    {
        $this->startNewRow();

        $a = str_split($row);
        foreach ($a as $height) {
            $this->addTree($height);
        }
    }

    public function map(): string
    {
        return array_reduce($this->rows, function (string $c, TreeRow $row) {
            $c .= $row->map() . "\n";
            return $c;
        }, '');
    }

    public function visible(): int
    {
        return array_reduce($this->rows, function (int $c, TreeRow $row) {
            $c += $row->visible();
            return $c;
        }, 0);
    }

    public function visibleMap(): string
    {
        return array_reduce($this->rows, function (string $c, TreeRow $row) {
            $c .= $row->visibleMap() . "\n";
            return $c;
        }, '');
    }

    public function highestScenicScore(): int
    {
        return array_reduce($this->rows, function (int $c, TreeRow $row) {
            return max($row->highestScenicScore(), $c);
        }, 0);
    }

    private function startNewRow(): void
    {
        $this->currentRow = new TreeRow(count($this->rows));
        $this->rows[] = $this->currentRow;
    }

    private function addTree(int $height): void
    {
        $tree = $this->currentRow->addTree($height);

        // find neighbors
        $this->addNorthNeighbor($tree);
        $this->addWestNeighbor($tree);
    }

    private function addNorthNeighbor(Tree $tree): void
    {
        // if row 0, none north
        if (count($this->rows) === 1) {
            return;
        }

        $n = $this->rows[$this->currentRow->position() - 1]->treeAt($tree->position());

        $tree->withNorthNeighbor($n);
        $n->withSouthNeighbor($tree);
    }

    private function addWestNeighbor(Tree $tree): void
    {
        // if col 0, none west
        if ($tree->position() === 0) {
            return;
        }

        $n = $this->currentRow->treeAt($tree->position() - 1);

        $tree->withWestNeighbor($n);
        $n->withEastNeighbor($tree);
    }
}
