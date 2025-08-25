<?php

namespace App\Services;

use App\Contracts\AuthenticationContract;
use App\Contracts\ParserContract;
use App\Contracts\ProductContainerContract;
use LogicException;
use Throwable;

final readonly class ParserService
{
    private PageSnapshotService $snapshotService;
    private ProductContainerService $productContainer;

    public function __construct(
        public string          $parserName,
        private ParserContract $parser
    )
    {
        $this->snapshotService = new PageSnapshotService(
            $this->parserName
        );

        $this->productContainer = new ProductContainerService();
    }

    /**
     * @throws Throwable
     */
    public function parse(): ProductContainerContract
    {
        if ($this->parser instanceof AuthenticationContract && !$this->parser->login()) {
            throw new LogicException("Error sign in site - $this->parserName");
        }

        $page = $this->snapshotService->loadLastSnapshot() ?? $this->parser->getDefaultPage();

        do {
            $products = $this->parser->parseMainPage($page);

            if (count($products) == 0) {
                return $this->productContainer;
            }

            foreach ($products as $product) {
                $dto = $this->parser->parseProduct($product);
                if ($dto) {
                    $this->productContainer->addProduct($dto);
                }
            }

            $page = $this->parser->getNextPage($page);

            $this->snapshotService->createOrUpdateSnapshot($page);

        } while ($page != null);

        return $this->productContainer;
    }
}