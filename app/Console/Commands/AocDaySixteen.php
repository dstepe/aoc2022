<?php

namespace App\Console\Commands;

use App\Aoc\Day16\FlowOptimizer;
use Illuminate\Console\Command;

class AocDaySixteen extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:16';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 16;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $control = new FlowOptimizer($this->getDayInputFile());

        $control->mapTunnels();
        $control->optimizeFlow();

        $this->output->info(sprintf('Released Pressure: %s', $control->releasedPressure()));

        return Command::SUCCESS;
    }
}
