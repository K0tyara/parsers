<?php

namespace App\Parsers\CableCoIl;

final class CableCoIl
{
    public const HOST = "www.cable.co.il";
    public const ORIGIN = "https://www.cable.co.il";
    public const CATEGORIES_CSS = ".menu a[href*='items']";
    public const PRODUCT_CARD_CSS = ".productBoxes li";
    public const PRODUCT_URL_NAME_PRICE_CATEGORY_CSS = ".productBoxes li  .item-name a";
    public const NEXT_PAGE_CSS = ".items-paging a.current + a";
    public const PAGE_URL = "%CATEGORY_PAGE%?PNum=%NUM_PAGE%";
}