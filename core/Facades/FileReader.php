<?php

namespace Core\Facades;

use Core\Abstracts\Facade;
use Core\Storage\FileReaderProvider;

/**
 * @method static string read(string $path)
 * @method static array readAllLines(string $path)
 */
class FileReader extends Facade
{

    protected static function getFacadeAccessor(): mixed
    {
        return new FileReaderProvider();
    }
}