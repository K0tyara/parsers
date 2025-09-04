<?php

namespace App\Parsers\Formatters;

use App\Formatters\ImageFormatter;
use App\Parsers\CableCoIl\DTO\ProductDTO;
use Core\Contracts\Formatters\FormatterContract;
use Exception;

final readonly class XamlFormatter implements FormatterContract
{

    /**
     * @param ProductDTO[] $items
     * @return array
     * @throws Exception
     */
    public function format(array $items): array
    {
        $result = [];
        foreach ($items as $item) {

            $result[] = [
                'link' => $item->link,
                'product_name' => $item->title,
                'code_sku' => $item->code,
                'price' => $item->price,
                'short_description' => $item->shortDescription,
                'full_description' => $item->description,
                'PDFs' => $item->pdf,
                'images' => ImageFormatter::format($item->images),
            ];
        }

        return $result;
    }
}