<?php

namespace App\TechnoRezef\Mappers;

use App\TechnoRezef\DTO\ProductCardDTO;

final class ProductCardMapper
{
    /**
     * @param array $cards
     * @return ProductCardDTO[]
     */
    public static function mapMany(array $cards): array
    {
        return array_map(fn($card) => new ProductCardDTO(...$card), $cards);
    }
}