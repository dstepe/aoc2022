<?php

namespace App\Aoc\Day07;

class Directory implements FileSystemObject
{
    private string $name;

    private Directory|null $parent;

    /**
     * @var FileSystemObject[]
     */
    private $contents = [];

    public function __construct(string $name, Directory $parent = null)
    {
        $this->name = $name;
        $this->parent = $parent;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function size(): int
    {
        return array_reduce($this->contents, function (int $total, FileSystemObject $item) {
            $total += $item->size();
            return $total;
        }, 0);
    }

    public function isDirectory(): bool
    {
        return true;
    }

    public function isFile(): bool
    {
        return false;
    }

    public function findDirectoriesUnder(int $size): array
    {
        $start = [];

        if ($this->size() < $size) {
            $start[] = $this;
        }

        $directories = $this->directories();
        return array_reduce($directories, function(array $c, Directory $item) use ($size) {
            return array_merge($c, $item->findDirectoriesUnder($size));
        }, $start);
    }

    public function directories(): array
    {
        return array_filter($this->contents, function (FileSystemObject $item) {
            return $item->isDirectory();
        });
    }

    public function parent(): Directory
    {
        return $this->parent;
    }

    public function get(string $name): Directory
    {
        return $this->contents[$name];
    }

    public function find(string $name): ?FileSystemObject
    {
        if ($this->name === $name) {
            return $this;
        }

        foreach ($this->contents as $item) {
            if ($item->name() === $name) {
                return $item;
            }

            $found = $item->find($name);

            if ($found !== null) {
                return $found;
            }
        }

        return null;
    }

    public function addFile(File $file): void
    {
        $this->contents[$file->name()] = $file;
    }

    public function addDirectory(Directory $directory): void
    {
        $this->contents[$directory->name()] = $directory;
    }
}
