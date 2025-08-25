<?php

namespace Core\Facades;

use Core\Abstracts\Facade;
use Core\Storage\FileWriterProvider;

/**
 * @method static bool put(string $fullPath, string $content)
 * @method static bool append(string $fullPath, string $content)
 * @method static bool appendLine(string $fullPath, string $content)
 */
class FileWriter extends Facade
{
    protected static function getFacadeAccessor(): mixed
    {
        return new FileWriterProvider();
    }
}