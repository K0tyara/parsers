<?php

namespace App\Parsers\CableCoIl;

use App\Abstracts\ParserServiceBase;
use App\Contracts\ParserContract;
use App\Contracts\ProductContainerContract;
use App\Contracts\TimeSleepContainer;
use App\Parsers\CableCoIl\DTO\PageDTO;

class ParserService extends ParserServiceBase
{
    public function __construct(string $parserName, ParserContract $parser, TimeSleepContainer $sleepManager, bool $withSnapshot = false)
    {
        parent::__construct($parserName, $parser, $sleepManager, $withSnapshot);
    }

    protected function parse(): ProductContainerContract
    {
        $categories = $this->parser->parseMainPage();

        foreach ($categories as $href => $name) {
            $page = new PageDTO(1, $href);

            do {
                $cards = $this->parser->parseProductsCards($page->getNextPageUrl());
                $this->sleepManager->sleepAfterParseProductPage();
                foreach ($cards as $card) {
                    if ($product = $this->parser->parseProduct($card)) {
                        $this->addProduct($product);
                    }
                    $this->sleepManager->sleepAfterParseProduct();
                }

            } while ($page = $this->parser->getNextPage($page));
        }

        return $this->getProductContainer();
    }
}