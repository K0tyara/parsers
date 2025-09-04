<?php

namespace App\Abstracts;

use App\Contracts\AuthenticationContract;
use App\Contracts\ParserContract;
use App\Contracts\ProductContainerContract;
use App\Contracts\TimeSleepContainer;
use App\Services\ProductContainerService;
use LogicException;

abstract class ParserServiceBase
{
    private readonly ProductContainerService $productContainer;

    public function __construct(
        public readonly string                $parserName,
        protected readonly ParserContract     $parser,
        protected readonly TimeSleepContainer $sleepManager,
        protected readonly bool               $withSnapshot = false
    )
    {
        $this->productContainer = new ProductContainerService();
    }


    public function execute(): ProductContainerContract
    {
        if ($this->parser instanceof AuthenticationContract && !$this->parser->login()) {
            throw new LogicException("Error sign in site - $this->parserName");
        }

        return $this->parse();
    }

    protected abstract function parse(): ProductContainerContract;


    protected function addProduct(Product $product): void
    {
        $this->productContainer->addProduct($product);
    }

    protected function getProductContainer(): ProductContainerService
    {
        return $this->productContainer;
    }

}