<?php

namespace App\TechnoRezef\DTO;

use App\Abstracts\ProductCard;

final readonly class ProductCardDTO extends ProductCard
{
    public function __construct(
        public string $title,
        public string $href,
        public array  $images,
        public string $status,
    )
    {

    }

}