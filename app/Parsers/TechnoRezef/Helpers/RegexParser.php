<?php

namespace App\Parsers\TechnoRezef\Helpers;

use LogicException;

final class RegexParser
{
    public static function parseProductMetaData(string $text): array
    {
        if (preg_match('/var\s+meta\s*=\s*(\{.*?\});/s', $text, $math)) {
            return json_decode($math[1], true);
        }

        throw new LogicException("Can`t parse product meta data.");
    }
}