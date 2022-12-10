<?php

namespace App\Console\Commands;

use App\Aoc\Day06\TuningTrouble;
use Illuminate\Console\Command;

class AocDaySix extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:6';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 6;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tuner = new TuningTrouble($this->getDayInputFile());

        $tuner->seek();

        $this->output->info(sprintf('Start of packet: %s', $tuner->startOfPacket()));
        $this->output->info(sprintf('Start of message: %s', $tuner->startOfMessage()));

        return Command::SUCCESS;
    }
}
