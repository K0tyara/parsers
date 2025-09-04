<?php

namespace App\Parsers\CableCoIl\DTO;

use App\Abstracts\Product;

readonly class ProductDTO extends Product
{
    public function __construct(
        public string $link,
        public string $title,
        public string $code,
        public string $shortDescription,
        public string $description,
        public string $price,
        public array  $images,
        public array  $categories,
        public string $pdf,


    )
    {
    }

    public function toArray(): array
    {
        return [
            'link' => $this->link,
            'title' => $this->title,
            'code' => $this->code,
            'shortDescription' => $this->shortDescription,
            'description' => $this->description,
            'price' => $this->price,
            'images' => $this->images,
            'categories' => $this->categories,
            'pdf' => $this->pdf,
        ];
    }
}