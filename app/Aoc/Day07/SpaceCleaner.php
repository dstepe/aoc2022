<?php

namespace App\Aoc\Day07;

class SpaceCleaner
{
    public const COMMAND_MODE = 'command';
    public const LIST_MODE = 'list';
    public const FILESYSTEM_SIZE = 70000000;
    public const REQUIRED_FREE_SPACE = 30000000;

    private \Iterator $input;

    private string $currentLine;

    private string $mode = self::COMMAND_MODE;

    private Directory $root;

    private Directory $currentDirectory;

    public function __construct(\Iterator $input)
    {
        $this->input = $input;

        $this->root = new Directory('/');
    }

    public function summarizeFileSpace(): void
    {
        foreach ($this->input as $line) {
            $this->currentLine = $line;
            $this->handleLine();
        }
    }

    public function find(string $name): FileSystemObject
    {
        return $this->root->find($name);
    }

    public function findDirectoriesUnder(int $size): array
    {
        return $this->root->findDirectoriesUnder($size);
    }

    public function findSizeOfDirectoriesUnder(int $size): int
    {
        return array_reduce($this->findDirectoriesUnder($size), function (int $c, Directory $d) {
            $c += $d->size();
            return $c;
        }, 0);
    }

    public function directorySizeToDelete(int $size): int
    {
        $candidates = $this->findDirectoriesUnder($size);
        usort($candidates, function (Directory $a, Directory $b) {
            if ($a->size() === $b->size()) {
                return 0;
            }
            return ($a->size() < $b->size()) ? -1 : 1;
        });

        $unused = self::FILESYSTEM_SIZE - $this->root->size();
        $needed = self::REQUIRED_FREE_SPACE - $unused;

        printf("Root size: %s, unused: %s, needed: %s\n", $this->root->size(), $unused, $needed);

        /** @var Directory $candidate */
        foreach ($candidates as $candidate) {
            printf("Candidate: %s\n", $candidate->size());
            if ($candidate->size() < $needed) {
                continue;
            }

            return $candidate->size();
        }

        return 0;
    }

    private function handleLine(): void
    {
        if ($this->isCommand()) {
            $this->processCommand();
            return;
        }

        $this->addToDirectory($this->currentLine);
    }

    private function processCommand(): void
    {
        if ($this->inListMode()) {
            $this->stopListMode();
        }

        $parts = explode(' ', str_replace('$ ', '', $this->currentLine), 2);

        switch ($parts[0]) {
            case 'cd':
                $this->changeDirectory($parts[1]);
                break;

            case 'ls':
                $this->startListMode();
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Command not supported: %s', $this->currentLine));
        }
    }

    private function isCommand(): bool
    {
        return str_starts_with($this->currentLine, '$');
    }

    private function isNotCommand(): bool
    {
        return !$this->isCommand();
    }

    private function changeDirectory(string $directory): void
    {
        switch ($directory) {
            case '/':
                $this->currentDirectory = $this->root;
                break;

            case '..':
                $this->currentDirectory = $this->currentDirectory->parent();
                break;

            default:
                $this->currentDirectory = $this->currentDirectory->get($directory);
                break;
        }
    }

    private function inListMode(): bool
    {
        return $this->mode === self::LIST_MODE;
    }

    private function inCommandMode(): bool
    {
        return $this->mode === self::COMMAND_MODE;
    }

    private function stopListMode(): void
    {
        $this->mode = self::COMMAND_MODE;
    }

    private function startListMode(): void
    {
        $this->mode = self::LIST_MODE;
    }

    private function addToDirectory(string $content): void
    {
        if (strpos($content, 'dir ') === 0) {
            $name = str_replace('dir ', '', $content);
            $this->currentDirectory->addDirectory(
                new Directory($name, $this->currentDirectory)
            );
            return;
        }

        [$size, $name] = explode(' ', $content, 2);
        $this->currentDirectory->addFile(new File($name, (int) $size));
    }
}
