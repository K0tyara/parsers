<?php

namespace Core\Contracts\Log;

use Throwable;

interface LogContract
{
    public function info(string $message): void;

    public function error(Throwable|string $exception): void;
}