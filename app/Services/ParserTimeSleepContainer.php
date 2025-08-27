<?php

namespace App\Services;

use App\Contracts\TimeSleepContainer;

final readonly class ParserTimeSleepContainer implements TimeSleepContainer
{
    public int $afterParseProductsPage;
    public int $afterParseProduct;

    public function __construct(
        int $afterParseProductsPage = 2,
        int $afterParseProduct = 2,
    )
    {
        $this->afterParseProduct = $afterParseProduct;
        $this->afterParseProductsPage = $afterParseProductsPage;
    }

    public function sleepAfterParseProductPage(): void
    {
        sleep($this->afterParseProductsPage);
    }

    public function sleepAfterParseProduct(): void
    {
        sleep($this->afterParseProduct);
    }
}