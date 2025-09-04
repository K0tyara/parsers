<?php

namespace App\Formatters;

final readonly class PriceFormatter
{
    public static function format($value): float
    {
        return round(floatval($value) / 100, 2);
    }
}