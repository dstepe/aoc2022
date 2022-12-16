<?php

namespace App\Console\Commands;

use App\Aoc\Day12\HillClimb;
use Illuminate\Console\Command;

class AocDayTwelve extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:12';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 12;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hillClimb = new HillClimb($this->getDayInputFile());

        $hillClimb->seekRoutes();

        $this->output->info(sprintf('Shortest route: %s', $hillClimb->shortestRoute()));

        return Command::SUCCESS;
    }
}
