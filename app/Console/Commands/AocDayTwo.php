<?php

namespace App\Console\Commands;

use App\Aoc\Day02\GameStrategyEnd;
use Illuminate\Console\Command;

class AocDayTwo extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 2;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $strategy = new GameStrategyEnd($this->getDayInputFile());

        $strategy->summarizeRounds();

        $this->output->info(sprintf('Game score: %s', $strategy->score()));

        return Command::SUCCESS;
    }
}
