<?php

namespace App\Services;

use App\Abstracts\Product;
use App\Contracts\ProductContainerContract;

final class ProductContainerService implements ProductContainerContract
{
    /**
     * @var Product[]
     */
    private array $products;


    public function __construct()
    {
        $this->products = [];
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * @return array|Product[]
     */
    public function products(): array
    {
        return $this->products;
    }

    public function count(): int
    {
        return count($this->products);
    }
}