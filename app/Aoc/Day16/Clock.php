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
        for ($i = 1; $i <= self::MINUTES; $i++) {
            print "== Minute $i ==\n";
            $this->events->each(function (TimedEvent $event) {
                $event->tick();
            });
            print "\n";
        }
    }
}
