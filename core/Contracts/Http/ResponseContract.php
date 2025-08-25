<?php

namespace Core\Contracts\Http;

interface ResponseContract
{
    public function status(): int;

    public function body(): string;

    public function error(): string;

    public function toJson(): false|array;

    public function isError(): bool;

    public function getCookies(): array;
}