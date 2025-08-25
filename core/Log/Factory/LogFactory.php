<?php

namespace Core\Log\Factory;

use Core\Contracts\Log\LogContract;
use Core\Facades\Storage;
use Core\Log\ConsoleFileLogProvider;
use Core\Log\FileLogProvider;

final class LogFactory
{
    public static function file(string $logName, string $disk = 'logs'): LogContract
    {
        return new FileLogProvider($logName, Storage::disk($disk));
    }

    public static function console(string $logName, string $disk = 'logs'): LogContract
    {
        return new ConsoleFileLogProvider($logName, Storage::disk($disk));
    }
}