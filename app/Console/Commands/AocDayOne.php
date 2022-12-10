<?php

namespace App\Console\Commands;

use App\Aoc\Day01\CalorieCounter;
use Illuminate\Console\Command;

class AocDayOne extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:1 {--top=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 1;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $top = $this->option('top');

        $counter = new CalorieCounter($this->getDayInputFile());

        $counter->summarizeCalories();

        $maxLoad = $counter->findMaxLoad($top);

        $this->output->info(sprintf('Max calorie load: %s', $maxLoad));

        return Command::SUCCESS;
    }

}
