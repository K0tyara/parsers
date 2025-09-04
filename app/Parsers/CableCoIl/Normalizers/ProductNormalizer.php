<?php

namespace App\Parsers\CableCoIl\Normalizers;

use App\Parsers\CableCoIl\CableCoIl;
use phpQuery;

final readonly class ProductNormalizer
{
    public static function normalize(string $body): array
    {
        $doc = phpQuery::newDocument($body);

        $images = array_map(function ($el) {
            return CableCoIl::ORIGIN . pq($el)->attr('href');
        }, pq("#product-thumbnails a[href*='large']")->get());

        $code = trim(pq('.model .details_wrap .value')->text());

        $vendor = trim(pq('.manufact .value')->text());

        $pdf = pq('.productfiles.pdf')->attr('href');

        $shortDescription = trim(pq('.product-short-desc')->text());
        $fullDescription = trim(pq('.description.tabs-block.editorcss')->text());

        phpQuery::unloadDocuments($doc);
        return [
            'images' => $images,
            'code' => $code,
            'vendor' => $vendor,
            'pdf' => $pdf,
            'shortDescription' => $shortDescription,
            'fullDescription' => $fullDescription
        ];
    }
}