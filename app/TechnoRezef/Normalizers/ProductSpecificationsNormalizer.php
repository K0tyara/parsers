<?php

namespace App\TechnoRezef\Normalizers;

final readonly class ProductSpecificationsNormalizer
{
    public static function normalize(array $elements): array
    {
        $result = [];
        foreach ($elements as $element) {
            $element = pq($element);
            $result[trim($element->find('.product-spec__label')->text())] =
                trim($element->find('.product-spec__value')->text());
        }

        return $result;
    }
}