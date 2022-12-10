<?php

namespace App\Console\Commands;

use App\Aoc\Day07\SpaceCleaner;
use Illuminate\Console\Command;

class AocDaySeven extends AocDay
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aoc:7';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $day = 7;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cleaner = new SpaceCleaner($this->getDayInputFile());

        $cleaner->summarizeFileSpace();

        $totalSize = $cleaner->findSizeOfDirectoriesUnder(100001);

        $this->output->info(sprintf('Total directory size: %s', $totalSize));

        $this->output->info(sprintf('Directory size to delete: %s', $cleaner->directorySizeToDelete(SpaceCleaner::FILESYSTEM_SIZE)));

        return Command::SUCCESS;
    }
}
