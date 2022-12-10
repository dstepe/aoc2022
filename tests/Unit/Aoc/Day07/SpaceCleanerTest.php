<?php

namespace Tests\Unit\Aoc\Day07;

use App\Aoc\Day07\Directory;
use App\Aoc\Day07\SpaceCleaner;
use PHPUnit\Framework\TestCase;

class SpaceCleanerTest extends TestCase
{
    public function testParsesTerminalOutput(): void
    {
        $cleaner = new SpaceCleaner(new \ArrayIterator($this->getOutput()));

        $cleaner->summarizeFileSpace();

        $root = $cleaner->find('/');

        $this->assertEquals('/', $root->name());
    }

    public function testReturnsSizeOfRootDirectory(): void
    {
        $cleaner = new SpaceCleaner(new \ArrayIterator($this->getOutput()));

        $cleaner->summarizeFileSpace();

        $this->assertEquals(48381165, $cleaner->find('/')->size());
    }

    public function testFindsDirectoryByName(): void
    {
        $cleaner = new SpaceCleaner(new \ArrayIterator($this->getOutput()));

        $cleaner->summarizeFileSpace();

        $this->assertEquals('e', $cleaner->find('e')->name());
    }

    public function testCalculatesTotalSizeOfDirectory(): void
    {
        $cleaner = new SpaceCleaner(new \ArrayIterator($this->getOutput()));

        $cleaner->summarizeFileSpace();

        $this->assertEquals(94853, $cleaner->find('a')->size());
    }

    public function testFindsDirectoriesUnderGivenSize(): void
    {
        $cleaner = new SpaceCleaner(new \ArrayIterator($this->getOutput()));

        $cleaner->summarizeFileSpace();

        $found = array_reduce($cleaner->findDirectoriesUnder(100000), function (array $c, Directory $d) {
            $c[] = $d->name();
            return $c;
        }, []);

        $this->assertEquals(['a', 'e'], $found);
    }

    public function testFindSizeOfDirectoriesUnderGivenSize(): void
    {
        $cleaner = new SpaceCleaner(new \ArrayIterator($this->getOutput()));

        $cleaner->summarizeFileSpace();

        $size = $cleaner->findSizeOfDirectoriesUnder(100000);

        $this->assertEquals(95437, $size);
    }

    private function getOutput(): array
    {
        return [
            '$ cd /',
            '$ ls',
            'dir a',
            '14848514 b.txt',
            '8504156 c.dat',
            'dir d',
            '$ cd a',
            '$ ls',
            'dir e',
            '29116 f',
            '2557 g',
            '62596 h.lst',
            '$ cd e',
            '$ ls',
            '584 i',
            '$ cd ..',
            '$ cd ..',
            '$ cd d',
            '$ ls',
            '4060174 j',
            '8033020 d.log',
            '5626152 d.ext',
            '7214296 k',
        ];
    }
}
