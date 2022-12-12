<?php

namespace App\Console\Commands;

use App\Aoc\Day11\MonkeyBusiness;
use App\Aoc\Day11\Troop;
use Illuminate\Console\Command;

class AocDayEleven extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:11';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 11;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $monkeyBusiness = new MonkeyBusiness($this->getDayInputFile());

        $monkeyBusiness->observeMonkeys();

        $monkeyBusiness->playRounds(20);

        $this->output->info(sprintf('Monkey business: %s', $monkeyBusiness->monkeyBusinessLevel()));

        return Command::SUCCESS;
    }
}
