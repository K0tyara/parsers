<?php

namespace App\Parsers\TechnoRezef\Formatters;

use App\Formatters\ImageFormatter;
use App\Parsers\TechnoRezef\DTO\ProductDTO;
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
                'productName' => htmlspecialchars($item->title, ENT_QUOTES | ENT_XML1, 'UTF-8'),
                'ManufacturerProductCode' => $item->code,
                'DealerPrice' => $item->price,
                'Inventorylevel' => $item->status,
//                'productCode' => ' ',
                'Warranty' => $item->extra['אחריות'] ? htmlspecialchars($item->extra['אחריות'], ENT_QUOTES | ENT_XML1, 'UTF-8') : ' ',
                'Weight' => $item->extra['משקל'] ?? ' ',
//                'Category Name' => ' ',
                'image' => htmlspecialchars(ImageFormatter::format($item->images), ENT_QUOTES | ENT_XML1, 'UTF-8')
            ];
        }

        return $result;
    }
}