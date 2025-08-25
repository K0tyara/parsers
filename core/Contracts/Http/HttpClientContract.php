<?php

namespace Core\Contracts\Http;

interface HttpClientContract
{
    public function request(string $method, string $url, string|array $data = [], array $headers = [], array $options = []): ResponseContract;
}