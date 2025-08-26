<?php

namespace App\Facades;

use App\Convectors\XamlConvector;
use Core\Abstracts\Facade;
use Core\Contracts\Formatters\FormatterContract;

/**
 * @method static string convert(array $items, string $childKey = 'Product', ?FormatterContract $formatterContract = null)
 */
class Xaml extends Facade
{

    protected static function getFacadeAccessor(): mixed
    {
        return new XamlConvector();
    }
}