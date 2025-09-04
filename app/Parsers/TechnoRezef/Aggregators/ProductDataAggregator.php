<?php

namespace App\Parsers\TechnoRezef\Aggregators;

use App\Formatters\PriceFormatter;
use App\Parsers\TechnoRezef\DTO\ProductCardDTO;
use App\Parsers\TechnoRezef\DTO\ProductDTO;
use App\Parsers\TechnoRezef\TechnoRezefCom;

class ProductDataAggregator
{
    /**
     * @param ProductCardDTO $cardDTO
     * @param array $meta
     * @param string $description
     * @param array $images
     * @param array $specifications
     * @return ProductDTO
     */
    public static function aggregate(ProductCardDTO $cardDTO, array $meta, string $description, array $images, array $specifications): ProductDTO
    {
        $meta = $meta['product']['variants'][0];

        return new ProductDTO(
            TechnoRezefCom::HOME . $cardDTO->href,
            $meta['sku'],
            $cardDTO->title,
            $description,
            PriceFormatter::format($meta['price']),
            $cardDTO->status,
            '',
            [],
            $images,
            $specifications
        );
    }
}