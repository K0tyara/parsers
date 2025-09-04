<?php

namespace App\Parsers\TechnoRezef\Normalizers;

use Exception;

final readonly class ProductImagesNormalizer
{
    /**
     * @param $elements
     * @return string[]
     * @throws Exception
     */
    public static function normalize($elements): array
    {
        return array_map(function ($element) {
            $href = pq($element)->attr('href');
            return 'https:' . substr($href, 0, strpos($href, '?'));
        }, $elements);
    }
}