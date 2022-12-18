<?php

namespace App\Console\Commands;

use App\Aoc\Day13\DistressSignal;
use Illuminate\Console\Command;

class AocDayThirteen extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:13';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 13;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $processor = new DistressSignal($this->getDayInputFile());

        $processor->processSignals();

        $this->output->info(sprintf('Correct packet indicator: %s', $processor->correctPacketIndicator()));

        return Command::SUCCESS;
    }
}
