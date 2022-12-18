<?php

namespace App\Aoc\Day13;

class Packet
{
    private ?array $values;

    private function __construct(?array $values)
    {
        $this->values = $values;
    }

    public static function fromLine(string $line): self
    {
        if (empty($line)) {
            return new self(null);
        }

        $data = eval(sprintf('return %s;', $line));

        $values = array_reduce($data, function (array $c, $value) {
            if (is_array($value)) {
                $c[] = new ValueArray($value);
            } else {
                $c[] = new ValueInteger($value);
            }

            return $c;
        }, []);
        return new self($data);
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function values(): array
    {
        return $this->values;
    }

    public function value(int $index)
    {
        if ($this->isNull()) {
            throw new \InvalidArgumentException('Packet is null');
        }

        return $this->values[$index];
    }

    public function isNull(): bool
    {
        return $this->values === null;
    }

    public function isNotNull(): bool
    {
        return !$this->isNull();
    }
}
