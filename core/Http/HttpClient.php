<?php

namespace Core\Http;

use Core\Contracts\Http\HttpClientContract;
use Core\Contracts\Http\HttpProviderContract;
use Core\Contracts\Http\ResponseContract;

class HttpClient implements HttpProviderContract
{

    public function __construct(
        private readonly HttpClientContract $client
    )
    {
    }


    private array $headers = [];
    private ?string $proxy = null;
    private bool $verify = true;

    private bool $isForm = false;
    private bool $withoutRedirects = false;

    public function withHeaders(array $headers): HttpProviderContract
    {
        $this->headers = array_merge(
            $this->headers,
            array_change_key_case($headers, CASE_LOWER)
        );

        return $this;
    }

    public function withoutRedirect(): HttpProviderContract
    {
        $this->withoutRedirects = true;
        return $this;
    }

    public function form(): HttpProviderContract
    {
        $this->isForm = true;
        return $this;
    }

    public function withoutVerify(): HttpProviderContract
    {
        $this->verify = false;

        return $this;
    }

    public function withProxy(string $proxy): HttpProviderContract
    {
        $this->proxy = $proxy;

        return $this;
    }

    public function get(string $url, array $query = []): ResponseContract
    {
        return $this->client->request('GET', $url, $query, $this->headers, $this->prepareOptions());
    }

    public function post(string $url, array $data): ResponseContract
    {
        if ($this->isForm) {
            $this->headers['content-type'] = 'application/x-www-form-urlencoded';
            $data = http_build_query($data);
        } else {
            $data = json_encode($data);
        }
        return $this->client->request('POST', $url, $data, $this->headers, $this->prepareOptions());
    }

    public function download(string $url, string $path): bool
    {
        $response = $this->client->request('GET', $url, '', [
            'accept-encoding' => 'gzip, deflate, br, zstd',
        ], $this->prepareOptions([
            'file' => $path
        ]));

        return $response->status() == 200;
    }

    private function prepareOptions(array $options = []): array
    {
        return array_merge([
            'proxy' => $this->proxy,
            'verify' => $this->verify,
            'redirect' => !$this->withoutRedirects
        ], $options);
    }
}