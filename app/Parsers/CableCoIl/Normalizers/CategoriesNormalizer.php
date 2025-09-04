<?php

namespace App\Parsers\CableCoIl\Normalizers;

use App\Parsers\CableCoIl\CableCoIl;

final readonly class CategoriesNormalizer
{
    public static function normalize(array $elements): array
    {
        $categories = [];
        foreach ($elements as $element) {
            $element = pq($element);

            $categories[CableCoIl::ORIGIN . $element->attr('href')] = trim($element->text());
        }

        return $categories;
    }
}