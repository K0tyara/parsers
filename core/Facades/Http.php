<?php

namespace Core\Facades;

use Core\Abstracts\Facade;
use Core\Contracts\Http\HttpProviderContract;
use Core\Contracts\Http\ResponseContract;
use Core\Http\Factory\HttpProviderFactory;

/**
 * @method static Http withHeaders(array $headers)
 * @method static Http form()
 * @method static Http withoutRedirect()
 * @method static Http withoutVerify()
 * @method static Http withProxy(string $proxy)
 * @method static ResponseContract get(string $url, array $query = [])
 * @method static ResponseContract post(string $url, array|string $data)
 * @method static bool download(string $url, string $path)
 */

final class Http extends Facade
{
    protected static function getFacadeAccessor(): HttpProviderContract
    {
        return HttpProviderFactory::get();
    }
}