<?php

namespace Core\Http\Curl;

use Core\Contracts\Http\ResponseContract;

final readonly class Response implements ResponseContract
{
    public function __construct(
        private int     $status,
        private ?string $body,
        private ?string $error,
        private array   $headers
    )
    {
    }

    public function getCookies(): array
    {
        return $this->headers;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function error(): string
    {
        return $this->error;
    }

    public function toJson(): false|array
    {
        if ($data = json_decode($this->body, true)) {
            return $data;
        }

        return false;
    }

    public function isError(): bool
    {
        return !$this->error;
    }
}