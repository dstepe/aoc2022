<?php

namespace App\Console\Commands;

use App\Aoc\Day05\SupplyStackRearrangement;
use Illuminate\Console\Command;

class AocDayFive extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 5;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arranger = new SupplyStackRearrangement($this->getDayInputFile());

        $arranger->mode(SupplyStackRearrangement::MULTI_MODE);
        $arranger->arrangeCrates();

        $this->output->info(sprintf('Top crates: %s', $arranger->topCrates()));

        return Command::SUCCESS;
    }
}
