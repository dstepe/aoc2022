<?php

namespace App\Aoc\Day16;

use Illuminate\Support\Collection;

class Clock
{
    public const MINUTES = 30;

    private Collection $events;

    public function __construct()
    {
        $this->events = new Collection();
    }

    public function add(TimedEvent $event): void
    {
        $this->events->add($event);
    }

    public function run(): void
    {
        for ($i = 0; $i < self::MINUTES; $i++) {
            printf("== Minute %s ==\n", $i + 1);
            $this->events->each(function (TimedEvent $event) use ($i) {
                $event->tick($i + 1, self::MINUTES - $i);
            });
            print "\n";
        }
    }
}
