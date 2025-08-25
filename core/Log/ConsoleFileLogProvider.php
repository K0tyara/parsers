<?php

namespace Core\Log;

use Throwable;

readonly class ConsoleFileLogProvider extends FileLogProvider
{

    public function info(string $message): void
    {
        echo $message . PHP_EOL;
        parent::info($message);
    }

    public function error(Throwable|string $exception): void
    {
        if ($exception instanceof Throwable) {
            $exception = $exception->getMessage();
        }
        echo $exception . PHP_EOL;
        parent::error($exception);
    }
}