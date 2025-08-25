<?php

namespace Core\Http;

use Core\Contracts\Http\HttpClientContract;
use Core\Contracts\Http\ResponseContract;
use Core\Http\Curl\Response;

class CurlClient implements HttpClientContract
{
    public function request(string $method, string $url, string|array $data = [], array $headers = [], array $options = []): ResponseContract
    {
        $ch = curl_init();

        $this->applyOptions($ch, $options);
        $this->applyHeaders($ch, $headers);

        if (strtolower($method) == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
        } else {
            if ($data) {
                $query = is_array($data) ? http_build_query($data) : $data;
                $url .= ('?' . $query);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);

        #флаг для возврата ответа
        #если есть флаг для скачивания файла то возврат не возможен
        if (!isset($options['file'])) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        }

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        [$body, $responseHeaders] = $this->splitHeadersAndBody($response, $headerSize);
        $error = curl_error($ch);

        curl_close($ch);

        return new Response(
            $status,
            $body,
            $error,
            $this->parseCookies($responseHeaders)
        );
    }

    private function splitHeadersAndBody($response, $headerSize): array
    {
        $rawHeaders = substr($response, 0, $headerSize);
        $body = substr($response, $headerSize);

        return [$body, $rawHeaders];
    }

    private function parseCookies($rawHeaders): array
    {
        preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $rawHeaders, $matches);
        $cookies = [];
        foreach ($matches[1] as $cookie) {
            parse_str($cookie, $parsedCookie);
            $cookies = array_merge($cookies, $parsedCookie);
        }

        return $cookies;
    }

    private function applyHeaders($ch, array $rawHeaders): void
    {
        if ($rawHeaders) {
            $headers = [];

            foreach ($rawHeaders as $name => $value) {
                $headers[] = "$name: $value";
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
    }

    private function applyOptions($ch, array $options): void
    {
        if ($options) {
            if (isset($options['proxy']) && $options['proxy']) {
                curl_setopt($ch, CURLOPT_PROXY, $options['proxy']);
            }
            if (isset($options['verify'])) {
                #отключаем проверку сертификатов
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $options['verify']);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $options['verify'] ? 2 : 0);
            }
            if (isset($options['file'])) {
                $fp = fopen($options['file'], 'w+');
                curl_setopt($ch, CURLOPT_FILE, $fp);
            }
            if (isset($options['redirect']) && $options['redirect']) {
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            } else {
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            }
        }
    }
}