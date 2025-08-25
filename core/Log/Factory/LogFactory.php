<?php

namespace Core\Log\Factory;

use Core\Contracts\Log\LogContract;
use Core\Facades\Storage;
use Core\Log\ConsoleFileLogProvider;
use Core\Log\FileLogProvider;
use Core\Storage\FileStorage;
use Core\Storage\FileWriterProvider;

final class LogFactory
{
    public static function get(string $logName, bool $consoleOutput = false): LogContract
    {
        $storage = Storage::disk('logs');
        if ($consoleOutput) {
            return new ConsoleFileLogProvider($logName, $storage);
        }
        return new FileLogProvider($logName, $storage);
    }
}