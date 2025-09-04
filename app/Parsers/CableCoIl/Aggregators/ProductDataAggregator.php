<?php

namespace App\Parsers\CableCoIl\Aggregators;

use App\Abstracts\ProductCard;
use App\Parsers\CableCoIl\DTO\ProductDTO;

final readonly class ProductDataAggregator
{
    public static function aggregate(ProductCard|ProductDTO $cardDTO, array $data): ProductDTO
    {
        return new ProductDTO(
            $cardDTO->href,
            $cardDTO->title,
            $data['code'],
            $data['shortDescription'],
            $data['fullDescription'],
            $cardDTO->price,
            $data['images'],
            $cardDTO->categories,
            $data['pdf']
        );
    }
}