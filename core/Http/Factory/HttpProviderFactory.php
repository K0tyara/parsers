<?php

namespace Core\Http\Factory;

use Core\Http\CurlClient;
use Core\Contracts\Http\HttpProviderContract;
use Core\Http\HttpClient;

final class HttpProviderFactory
{
    public static function get(): HttpProviderContract
    {
        $client = new CurlClient();

        return new HttpClient($client);
    }
}