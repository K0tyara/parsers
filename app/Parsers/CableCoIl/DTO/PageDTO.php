<?php

namespace App\Parsers\CableCoIl\DTO;

use App\Abstracts\Page;
use LogicException;

final readonly class PageDTO extends Page
{
    public function __construct(
        public int    $currentPage,
        public string $nextPage
    )
    {
    }

    public function getNextPageUrl(): string
    {
        return $this->nextPage;
    }

    public function getPageUrl(): string
    {
        throw new LogicException('Method getPageUrl not implements');
    }
}