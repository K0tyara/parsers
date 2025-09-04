<?php

namespace App\Formatters;

final readonly class ImageFormatter
{
    public static function format(array $images): string
    {
        return implode('\\\\\\', $images);
    }
}