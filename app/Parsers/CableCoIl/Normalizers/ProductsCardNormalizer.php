<?php

namespace App\Parsers\CableCoIl\Normalizers;

use App\Parsers\CableCoIl\CableCoIl;
use App\Parsers\CableCoIl\DTO\ProductCardDTO;

final readonly class ProductsCardNormalizer
{
    public static function normalize(array $elements): array
    {
        $cards = [];
        foreach ($elements as $element) {
            $element = pq($element);

            $categories = trim($element->attr('ee_list_category'));
            $cards[] = new ProductCardDTO(
                CableCoIl::ORIGIN . $element->attr('href'),
                trim($element->attr('ee_list_itemname')),
                explode('/', $categories),
                trim($element->attr('ee_list_itemprice')),
            );
        }

        return $cards;
    }
}