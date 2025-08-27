<?php

namespace Core\Facades;

use Core\Abstracts\Facade;
use Core\Contracts\Storage\StorageContract;
use Core\Storage\FileStorage;

/**
 * @method static bool isExist(string $path, bool $isDirectory)
 * @method static bool createDir(string $path)
 * @method static string getRandomPath(string $extension)
 * @method static void delete(string $fullPath)
 * @method static string getDiskPath()
 */
final class Storage extends Facade
{
    private static ?StorageContract $instance = null;

    public static function disk(string $disk): StorageContract
    {
        self::$instance = FileStorage::disk($disk);
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        //TODO:: ??
        if (!self::$instance) {
            throw new \RuntimeException("Storage disk not initialized. Call Storage::disk('name') first.");
        }

        return self::$instance->$method(...$args);
    }

    protected static function getFacadeAccessor(): mixed
    {
        return new FileStorage();
    }
}