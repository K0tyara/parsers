<?php

namespace Core\Log;

use Carbon\Carbon;
use Core\Contracts\Log\LogContract;
use Core\Contracts\Storage\FileWriterContract;
use Core\Contracts\Storage\StorageContract;
use Core\Facades\FileWriter;
use Exception;
use Throwable;

readonly class FileLogProvider implements LogContract
{
    private string $path;

    public function __construct(
        private string             $logName,
        private StorageContract    $storageContract,
    )
    {
        $this->path = $this->storageContract->getDiskPath() . "/$this->logName.txt";
    }

    public function info(string $message): void
    {
        FileWriter::appendLine(
            $this->path,
            $this->formattedMessage('info', $message)
        );
    }

    public function error(Throwable|string $exception): void
    {
        if ($exception instanceof Exception) {
            $exception = $exception->getMessage();
        }

        FileWriter::appendLine(
            $this->path,
            $this->formattedMessage('error', $exception));
    }

    private function formattedMessage(string $level, string $message): string
    {
        return '[' . Carbon::now()->toDateTimeString() . "] $level: $message";
    }
}