<?php

namespace App\TechnoRezef\Aggregators;

use App\TechnoRezef\DTO\ProductCardDTO;
use App\TechnoRezef\DTO\ProductDTO;
use App\TechnoRezef\Formatters\PriceFormatter;
use App\TechnoRezef\TechnoRezefCom;

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
            '',
            $images,
            $specifications
        );
    }
}