<?php

namespace App\Aoc\Day09;

class ChangeCalculator
{
    public function calculateChange(Position $head, Position $tail): Change
    {
        if ($this->touching($head, $tail)) {
            return new Change(0, 0);
        }

        $headRow = $head->row();
        $headColumn = $head->column();
        $tailRow = $tail->row();
        $tailColumn = $tail->column();

        if ($headRow !== $tailRow && $headColumn !== $tailColumn) {
            $moveRow = $headRow > $tailRow ? 1 : -1;
            $moveColumn = $headColumn > $tailColumn ? 1 : -1;
            return new Change($moveRow, $moveColumn);
        }

        if ($headRow !== $tailRow) {
            $move = $headRow > $tailRow ? 1 : -1;
            return new Change($move, 0);
        }

        $move = $headColumn > $tailColumn ? 1 : -1;
        return new Change(0, $move);
    }

    private function touching(Position $head, Position $tail): bool
    {
        $rowDiff = abs($head->row() - $tail->row());
        $columnDiff = abs($head->column() - $tail->column());

        return max($rowDiff, $columnDiff) <= 1;
    }
}
