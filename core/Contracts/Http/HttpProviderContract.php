<?php

namespace Core\Contracts\Http;

interface HttpProviderContract
{
    public function withHeaders(array $headers): HttpProviderContract;

    public function withoutVerify(): HttpProviderContract;

    public function withProxy(string $proxy): HttpProviderContract;

    public function get(string $url, array $query = []): ResponseContract;

    public function post(string $url, array $data): ResponseContract;

    public function download(string $url, string $path): bool;
}