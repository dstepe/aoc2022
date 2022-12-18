<?php

namespace App\Aoc\Day13;

class PacketComparison
{
    public function packetsAreInOrder(Packet $left, Packet $right): bool
    {
        return $this->compareValues($left->values(), $right->values());
    }

    private function compareValues(array $left, array $right): ?bool
    {
        $leftCount = count($left);
        $rightCount = count($right);

        for($i = 0; $i < $leftCount; $i++) {
            if ($i >= $rightCount) {
                return false;
            }

            $leftValue = $left[$i];
            $rightValue = $right[$i];

            if (!is_array($leftValue) && !is_array($rightValue)) {
                if ($leftValue === $rightValue) {
                    continue;
                }

                return $leftValue < $rightValue;
            }

            if (is_array($leftValue) && is_array($rightValue)) {
                $result = $this->compareValues($leftValue, $rightValue);

                if ($result !== null) {
                    return $result;
                }
            }

            if (is_array($leftValue) || is_array($rightValue)) {
                $leftValue = is_array($leftValue) ? $leftValue : [$leftValue];
                $rightValue = is_array($rightValue) ? $rightValue : [$rightValue];

                $result = $this->compareValues($leftValue, $rightValue);

                if ($result !== null) {
                    return $result;
                }
            }
        }

        if ($leftCount < $rightCount) {
            return true;
        }

        return null;
    }
}
