<?php

namespace App\Console\Commands;

use App\Aoc\Day08\TreetopView;
use Illuminate\Console\Command;

class AocDayEight extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:8';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 8;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $viewer = new TreetopView($this->getDayInputFile());

        $viewer->makeMap();

        $this->output->info(sprintf('Visible trees: %s', $viewer->visible()));
        $this->output->info(sprintf('Most scenic view: %s', $viewer->highestScenicScore()));

        return Command::SUCCESS;
    }
}
