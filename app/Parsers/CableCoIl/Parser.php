<?php

namespace App\Parsers\CableCoIl;

use App\Abstracts\Page;
use App\Abstracts\Product;
use App\Abstracts\ProductCard;
use App\Contracts\ParserContract;
use App\Parsers\CableCoIl\Aggregators\ProductDataAggregator;
use App\Parsers\CableCoIl\DTO\PageDTO;
use App\Parsers\CableCoIl\Normalizers\CategoriesNormalizer;
use App\Parsers\CableCoIl\Normalizers\ProductNormalizer;
use App\Parsers\CableCoIl\Normalizers\ProductsCardNormalizer;
use App\Services\Headers;
use Core\Contracts\Log\LogContract;
use Core\Facades\Http;
use phpQuery;

class Parser implements ParserContract
{

    private ?Page $page = null;
    private readonly Headers $headers;

    public function __construct(
        private readonly LogContract $logger
    )
    {
        $this->headers = new Headers(
            CableCoIl::HOST,
            CableCoIl::ORIGIN
        );
    }

    /**
     * @param ?Page $page
     * @return array
     */
    public function parseMainPage(?Page $page = null): array
    {
        $response = Http::withHeaders($this->headers->getHeaders())
            ->withoutVerify()
            ->get(CableCoIl::ORIGIN);

        if ($response->status() != 200) {
            $this->logger->error("Error parse: {$page->getNextPageUrl()} Error: {$response->error()}");
            return [];
        }

        $doc = phpQuery::newDocument($response->body());

        $categories = CategoriesNormalizer::normalize(
            pq(CableCoIl::CATEGORIES_CSS)->get()
        );

        phpQuery::unloadDocuments($doc);

        return $categories;

    }

    public function parseProductsCards(string $href): array
    {
        $response = Http::withHeaders($this->headers->getHeaders())
            ->withoutVerify()
            ->get($href);

        if ($response->status() != 200) {
            $this->logger->error("Error parse products card $href Error: {$response->error()}");
            return [];
        }

        $doc = phpQuery::newDocument($response->body());

        $cards = ProductsCardNormalizer::normalize(
            pq(CableCoIl::PRODUCT_URL_NAME_PRICE_CATEGORY_CSS)->get()
        );

        $nextPage = pq(CableCoIl::NEXT_PAGE_CSS);
        if ($nextPage->count()) {
            $this->page = new PageDTO(
                intval(trim($nextPage->text()) - 1),
                $nextPage->attr('href')
            );
        } else {
            $this->page = null;
        }

        phpQuery::unloadDocuments($doc);

        return $cards;
    }

    public function parseProduct(ProductCard $product): ?Product
    {
        $response = Http::withHeaders($this->headers->getHeaders())
            ->withoutVerify()
            ->get($product->href);

        if ($response->status() != 200) {
            $this->logger->error("Error parse: [$product->title] $product->href Error: {$response->error()}");
            return null;
        }

        $data = ProductNormalizer::normalize($response->body());

        return ProductDataAggregator::aggregate($product, $data);

    }

    public function getDefaultPage(): Page
    {

    }

    public function getNextPage(Page $page): ?Page
    {
        return $this->page;
    }

    public function isLastPage(): bool
    {
        return false;
    }

}