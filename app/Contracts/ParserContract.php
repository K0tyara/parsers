<?php

namespace App\Contracts;

use App\Abstracts\Page;
use App\Abstracts\Product;
use App\Abstracts\ProductCard;
use Core\Contracts\Formatters\FormatterContract;

interface ParserContract
{
    /**
     * @param ?Page $page
     * @return mixed
     */
    public function parseMainPage(?Page $page = null): array;

    public function parseProduct(ProductCard $product): ?Product;

    /**
     * @param string $href
     * @return ProductCard[]
     */
    public function parseProductsCards(string $href): array;

    public function getDefaultPage(): Page;

    public function getNextPage(Page $page): ?Page;

    public function isLastPage(): bool;
}