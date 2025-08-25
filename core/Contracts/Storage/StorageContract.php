<?php

namespace Core\Contracts\Storage;

interface StorageContract
{

    public static function disk(string $disk): self;

    public function getDiskPath(): string;

    public function isExist(string $path, bool $isDirectory);

    function createDir(string $path): bool;

    public function getRandomPath(string $extension): string;

    public function delete(string $fullPath): void;
}