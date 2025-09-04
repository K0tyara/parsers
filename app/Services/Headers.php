<?php

namespace App\Services;

final readonly class Headers
{
    public function __construct(
        public string  $host,
        public string  $origin,
        public ?string $referer = null
    )
    {
    }

    public function getHeaders(): array
    {
        return array_merge([
            'priority' => 'u=0, i',
            'sec-ch-ua-mobile' => '?0',
            'Sec-Fetch-Site' => 'cross-site',
            'Sec-Fetch-Mode' => 'navigate',
            'Sec-Fetch-Dest' => 'document',
            'sec-fetch-user' => '?1',
            'upgrade-insecure-requests' => '?1',
        ], self::baseHeaders());
    }

    public function jsonHeaders(): array
    {
        return array_merge([
            'content-type' => 'text/plain;charset=UTF-8',
            'priority' => 'u=1, i',
            'sec-ch-ua-mobile' => '?0',
            'Sec-Fetch-Site' => 'same-origin',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Dest' => 'empty',
            'x-nextjs-data' => '1',
        ], self::baseHeaders());
    }

    private function baseHeaders(): array
    {
        return [
            'Accept' => '*/*',
            'accept-encoding' => 'gzip, deflate, br, zstd',
            'accept-language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;',
            'cache-control' => 'no-cache',
            'origin' => $this->origin,
            'pragma' => 'no-cache',
//            'referer' => 'https://techno-rezef.com',
            'host' => $this->host,
            'sec-ch-ua-platform' => '"Windows"',
            'sec-ch-ua' => '"Not;A=Brand";v="99", "Google Chrome";v="139", "Chromium";v="139"',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36',
        ];
    }
}