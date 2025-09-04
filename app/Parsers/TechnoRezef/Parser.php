<?php

namespace App\Parsers\TechnoRezef;

use App\Abstracts\Page;
use App\Abstracts\Product;
use App\Abstracts\ProductCard;
use App\Contracts\AuthenticationContract;
use App\Contracts\ParserContract;
use App\Enums\ParserList;
use App\Parsers\TechnoRezef\Aggregators\ProductDataAggregator;
use App\Parsers\TechnoRezef\DTO\PageDataDTO;
use App\Parsers\TechnoRezef\DTO\ProductCardDTO;
use App\Parsers\TechnoRezef\Formatters\XamlFormatter;
use App\Parsers\TechnoRezef\Helpers\RegexParser;
use App\Parsers\TechnoRezef\Mappers\ProductCardMapper;
use App\Parsers\TechnoRezef\Normalizers\ProductCardNormalizer;
use App\Parsers\TechnoRezef\Normalizers\ProductImagesNormalizer;
use App\Parsers\TechnoRezef\Normalizers\ProductSpecificationsNormalizer;
use Core\Contracts\Formatters\FormatterContract;
use Core\Contracts\Log\LogContract;
use Core\Facades\Http;
use LogicException;
use phpQuery;
use Throwable;

final  class Parser implements ParserContract, AuthenticationContract
{
    private array $cookies = [];
    private bool $isLastPage = false;

    public function __construct(
        private readonly LogContract $logger
    )
    {
    }

    /**
     * @param ?PageDataDTO $page
     * @return mixed
     * @throws Throwable
     */
    public function parseMainPage(?Page $page = null): array
    {
        $response = Http::withHeaders($this->getHeadersWithCookie())
            ->get($page->getNextPageUrl());

        if ($response->status() != 200 || $response->error()) {
            $this->logger->error("Error parse: {$page->getNextPageUrl()} Error: {$response->error()}");
            return [];
        }

        $doc = phpQuery::newDocument($response->body());
        try {

            $cards = pq('ul product-card')->get();
            if (count($cards) == 0) {
                $this->isLastPage = true;
                return [];

            }
            $this->logger->info("Complete parse page: $page->currentPage");

            return ProductCardMapper::mapMany(
                ProductCardNormalizer::normalize($cards)
            );

        } catch (Throwable $ex) {
            $this->logger->error("Error normalize product cards. Exception: {$ex->getMessage()}");
            throw $ex;
        } finally {
            phpQuery::unloadDocuments($doc);
        }
    }


    /**
     * @param ProductCardDTO $product
     * @return Product|null
     */
    public function parseProduct(ProductCard $product): ?Product
    {
        $url = TechnoRezefCom::HOME . $product->href;
        $response = Http::withHeaders($this->getHeadersWithCookie())
            ->get($url);

        if ($response->status() != 200 || $response->error()) {
            $this->logger->error("Error product parse: {$url} Error: {$response->error()}");
            return null;
        }

        $doc = phpQuery::newDocument($response->body());
        try {
            $meta = RegexParser::parseProductMetaData($response->body());

            $images = ProductImagesNormalizer::normalize(
                pq('#gallery-viewer li a')->get()
            );

            $specifications = ProductSpecificationsNormalizer::normalize(
                pq('ul.product-spec li')->get()
            );

            $description = trim(pq('short_info')->text());

            $this->logger->info("Complete parse product: $product->title");
            return ProductDataAggregator::aggregate($product, $meta, $description, $images, $specifications);

        } catch (Throwable $e) {
            $this->logger->error("Error aggregate product: {$url}");
            return null;
        } finally {
            phpQuery::unloadDocuments($doc);
        }
    }

    public function getDefaultPage(): Page
    {
        return new PageDataDTO(0, 0, 0);
    }


    public function getNextPage(Page $page): ?Page
    {
        /** @var PageDataDTO $page */
        if ($this->isLastPage) {
            return null;
        }
        return new PageDataDTO($page->perPage, $page->currentPage + 1, $page->totalPages);
    }

    private function getHeadersWithCookie(): array
    {
        return array_merge(Headers::getHeaders(), [
            'cookie' => implode('; ', array_map(
                fn($name, $value) => $name . '=' . $value,
                array_keys($this->cookies),
                $this->cookies
            ))
        ]);
    }

    public function login(): bool
    {
        $login = config('parser.' . ParserList::TechnoRezef->value . '.login');
        $password = config('parser.' . ParserList::TechnoRezef->value . '.password');

        $data = [
            'form_type' => 'customer_login',
            'utf8' => '✓',
            'customer[email]' => $login,
            'customer[password]' => $password
        ];

        $response = Http::withHeaders(Headers::getHeaders())
            ->withoutRedirect()
            ->form()
            ->post(TechnoRezefCom::LOGIN, $data);

        if ($response->status() != 302) {
            throw new LogicException("Error login on site. Code: {$response->status()}");
        }

        $this->cookies = $response->getCookies();
        return true;
    }

    public function isLastPage(): bool
    {
        return $this->isLastPage;
    }

    public function parseProductsCards(string $href): array
    {
        return [];
    }
}