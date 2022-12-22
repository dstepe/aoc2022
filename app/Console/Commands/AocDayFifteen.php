<?php

namespace App\Console\Commands;

use App\Aoc\Day15\BeaconExclusion;
use Illuminate\Console\Command;

class AocDayFifteen extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:15';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 15;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $analyzer = new BeaconExclusion($this->getDayInputFile());

        $analyzer->loadBeacons();
        $analyzer->analyzeRow(2000000);

        $this->output->info(sprintf('Excluded positions: %s', $analyzer->exclusions()));
        $this->output->info(sprintf(
            'Undetected beacon tuning frequencey: %s',
            $analyzer->undetectedBeaconTuningFrequency(4000000, 2177081))
        );

        return Command::SUCCESS;
    }
}
