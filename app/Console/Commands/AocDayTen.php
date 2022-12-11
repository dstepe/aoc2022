<?php

namespace App\Console\Commands;

use App\Aoc\Day10\CathodeRayTube;
use Illuminate\Console\Command;

class AocDayTen extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:10';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 10;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $crt = new CathodeRayTube($this->getDayInputFile());

        $crt->processSignals();

        print $crt->display();

        $this->output->info(sprintf('Signal strength: %s', $crt->signalStrength()));

        return Command::SUCCESS;
    }
}
