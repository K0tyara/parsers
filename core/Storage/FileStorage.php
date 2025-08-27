<?php

namespace Core\Storage;

use Core\Contracts\Storage\StorageContract;

final readonly class FileStorage implements StorageContract
{
    private string $path;

    public function __construct(
        string $disk = null
    )
    {
        if ($disk) {
            $this->path = base_path("storage/$disk");
        } else {
            $this->path = base_path();
        }
    }

    public static function disk(string $disk): StorageContract
    {
        return new FileStorage($disk);
    }

    public function isExist(string $path, bool $isDirectory): bool
    {
        $path = "$this->path/" . ltrim($path, '/');
        if ($isDirectory) {
            return is_dir($path);
        } else {
            return file_exists($path);
        }
    }

    public function createDir(string $path): bool
    {
        $fullPath = "$this->path/" . ltrim($path, '/');

        #рекурсивное создание
        if (!is_dir($fullPath)) {
            return mkdir($fullPath, 0777, true);
        }

        return true;
    }

    public function getRandomPath(string $extension): string
    {
        #Генерация случайного имени файла
        $filename = bin2hex(random_bytes(16)) . '.' . ltrim($extension, '.');

        return $this->path . '/' . $filename;
    }

    public function delete(string $fullPath): void
    {
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function getDiskPath(): string
    {
        return $this->path;
    }
}