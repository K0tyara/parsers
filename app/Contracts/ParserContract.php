<?php

namespace App\Contracts;

use App\Abstracts\Page;
use App\Abstracts\Product;
use App\Abstracts\ProductCard;
use Core\Contracts\Formatters\FormatterContract;

interface ParserContract
{
    /**
     * @param Page $page
     * @return ProductCard[]
     */
    public function parseMainPage(Page $page): array;

    public function parseProduct(ProductCard $product): ?Product;

    public function getDefaultPage(): Page;

    public function getNextPage(Page $page): ?Page;

    public function getFormatter(): FormatterContract;

    public function isLastPage(): bool;
}