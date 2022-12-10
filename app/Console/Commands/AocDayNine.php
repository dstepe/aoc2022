<?php

namespace App\Console\Commands;

use App\Aoc\Day09\RopeBridgeModeler;
use Illuminate\Console\Command;

class AocDayNine extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:9';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 9;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bridge = new RopeBridgeModeler($this->getDayInputFile());

        $bridge->processMoves();

        print $bridge->visited();

        $this->output->info(sprintf('Visited positions: %s', $bridge->visitedCount()));

        return Command::SUCCESS;
    }
}
