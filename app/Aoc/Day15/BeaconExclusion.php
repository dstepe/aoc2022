<?php

namespace App\Aoc\Day15;

use Illuminate\Support\Collection;

class BeaconExclusion
{
    private \Iterator $input;

    private Collection $sensors;

    private SensorRow $row;

    private Collection $knownBeacons;
    private int $excluded = 0;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->sensors = new Collection();
        $this->knownBeacons = new Collection();
    }

    public function loadBeacons(): void
    {
        $factory = new SensorFactory();

        foreach ($this->input as $line) {
            $this->sensors->add($factory->fromLine($line));
        }

        $this->findKnownBeacons();
    }

    public function analyzeRow(int $row): void
    {
        $this->row = new SensorRow($row, $this->knownBeacons);

        $this->sensors->each(function (Sensor $sensor) {
            $this->row->checkSensor($sensor);
        });

        $this->excluded = $this->row->excluded();
    }

    public function exclusions():int
    {
        return $this->excluded;
    }

    public function undetectedBeaconTuningFrequency(int $upperBound, int $startRow = 0, int $announce = 10000): int
    {
        for ($i = $startRow; $i <= $upperBound; $i++) {
            if ($i % $announce === 0) {
                printf("Analyzed %s rows\n", $i);
            }

            $this->analyzeRow($i);

            $uncovered = $this->row->uncoveredInRange(0, $upperBound);
            if ($uncovered->isEmpty()) {
                continue;
            }

            /** @var Point $point */
            $point = $uncovered->first();

            return $point->tuningFrequency();
        }

        return 0;
    }

    private function findKnownBeacons(): void
    {
        $this->knownBeacons = $this->sensors->reduce(function (Collection $c, Sensor $sensor) {
            $c->put($sensor->beacon()->label(), $sensor->beacon());
            return $c;
        }, new Collection);
    }
}
