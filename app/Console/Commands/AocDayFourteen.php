<?php

namespace App\Console\Commands;

use App\Aoc\Day14\ReservoirSand;
use Illuminate\Console\Command;

class AocDayFourteen extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:14';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 14;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $monitor = new ReservoirSand($this->getDayInputFile());

        $monitor->scanStructure();

        $monitor->dropSand();

        print $monitor->map();
        
        $this->output->info(sprintf('Sand capacity: %s', $monitor->capacity()));

        return Command::SUCCESS;
    }
}
