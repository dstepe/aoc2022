<?php

namespace App\Console\Commands;

use App\Aoc\Day04\AssignmentChecker;
use Illuminate\Console\Command;

class AocDayFour extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:4';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 4;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $checker = new AssignmentChecker($this->getDayInputFile());

        $checker->checkAssignments();

        $this->output->info(sprintf('Contained assignments: %s', $checker->containsCount()));
        $this->output->info(sprintf('Overlapped assignments: %s', $checker->overlapsCount()));

        return Command::SUCCESS;
    }
}
