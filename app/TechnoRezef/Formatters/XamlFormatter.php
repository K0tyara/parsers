<?php

namespace App\TechnoRezef\Formatters;

use App\TechnoRezef\DTO\ProductDTO;
use App\TechnoRezef\Normalizers\ProductImagesNormalizer;
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

//            $description = str_replace('<br>', ' ', $item->description);
//            $html = "<h3>$item->title</h3>\n";
//            $html .= "<p>$description</p>\n";
//            foreach ($item->extra as $h3 => $p) {
//                $html .= "<h3>$h3</h3>\n";
//                $html .= "<p>$p</p>\n";
//            }

            $result[] = [
                'url' => $item->link,
                'productName' => $item->title,
                'ManufacturerProductCode' => $item->code,
                'DealerPrice' => $item->price,
                'Inventorylevel' => $item->status,
//                'productCode' => ' ',
                'Warranty' => $item->extra['אחריות'] ?? ' ',
                'Weight' => $item->extra['משקל'] ?? ' ',
//                'Category Name' => ' ',
                'image' => ImageFormatter::format($item->images),
            ];
        }

        return $result;
    }
}