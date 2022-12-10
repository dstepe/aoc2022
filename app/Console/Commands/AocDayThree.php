<?php

namespace App\Console\Commands;

use App\Aoc\Day03\RucksackReorganization;
use Illuminate\Console\Command;

class AocDayThree extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 3;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $organizer = new RucksackReorganization($this->getDayInputFile());

        $organizer->searchRucksacks();

        $this->output->info(sprintf('Total prioritization: %s', $organizer->totalPriority()));
        $this->output->info(sprintf('Total badge prioritization: %s', $organizer->totalBadgePriority()));

        return Command::SUCCESS;
    }
}
