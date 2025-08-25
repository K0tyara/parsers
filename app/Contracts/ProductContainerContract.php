<?php

namespace App\Contracts;

use App\Abstracts\Product;

interface ProductContainerContract
{
    /**
     * @return Product[]
     */
    public function products(): array;

    public function count(): int;
}