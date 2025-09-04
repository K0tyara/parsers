<?php

namespace App\Parsers\CableCoIl\DTO;

use App\Abstracts\ProductCard;

readonly class ProductCardDTO extends ProductCard
{
    public function __construct(
        public string $href,
        public string $title,
        public array $categories,
        public string $price
    )
    {
    }
}