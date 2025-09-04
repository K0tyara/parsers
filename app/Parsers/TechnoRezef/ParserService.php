<?php

namespace App\Parsers\TechnoRezef;

use App\Abstracts\ParserServiceBase;
use App\Contracts\ParserContract;
use App\Contracts\ProductContainerContract;
use App\Contracts\TimeSleepContainer;
use App\Services\PageSnapshotService;
use Throwable;

class ParserService extends ParserServiceBase
{

    private ?PageSnapshotService $snapshotService = null;

    public function __construct(string $parserName, ParserContract $parser, TimeSleepContainer $sleepManager, bool $withSnapshot = false)
    {
        parent::__construct($parserName, $parser, $sleepManager, $withSnapshot);

        if ($withSnapshot) {

            $this->snapshotService = new PageSnapshotService(
                $this->parserName
            );
        }
    }


    /**
     * @throws Throwable
     */
    public function parse(): ProductContainerContract
    {
        if ($this->withSnapshot) {
            $page = $this->snapshotService->loadLastSnapshot() ?? $this->parser->getDefaultPage();
        } else {
            $page = $this->parser->getDefaultPage();
        }

        do {
            $products = $this->parser->parseMainPage($page);
            $this->sleepManager->sleepAfterParseProductPage();
            if (count($products) == 0) {
                return $this->getProductContainer();
            }

            foreach ($products as $product) {
                $dto = $this->parser->parseProduct($product);
                if ($dto) {
                    $this->addProduct($dto);
                }
                $this->sleepManager->sleepAfterParseProduct();
            }

            $page = $this->parser->getNextPage($page);

            $this->snapshotService->createOrUpdateSnapshot($page);

        } while ($page != null);

        return $this->getProductContainer();
    }
}