<?php

namespace App\Parsers\TechnoRezef\DTO;

use App\Abstracts\Product;

final readonly class ProductDTO extends Product
{
    public function __construct(
        public string $link,
        public string $code,
        public string $title,
        public string $description,
        public string $price,
        public string $status,
        public string $html,
        public array $categories,
        public array $images,
        public array  $extra = []
    )
    {

    }

    public function toArray(): array
    {
        return [
            'link' => $this->link,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'html' => $this->html,
            'categories' => $this->categories,
            'images' => $this->images,
            'extra' => $this->extra,
        ];
    }
}