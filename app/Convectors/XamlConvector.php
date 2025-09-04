<?php

namespace App\Convectors;

use Core\Contracts\Convectors\XamlConvectorContract;
use Core\Contracts\Formatters\FormatterContract;
use DOMDocument;
use SimpleXMLElement;

class XamlConvector implements XamlConvectorContract
{
    public function convert(array $items, string $childKey = 'Product', ?FormatterContract $formatterContract = null): string
    {
        if ($formatterContract != null) {
            $items = $formatterContract->format($items);
        }

        $xaml = new SimpleXMLElement('<xml></xml>');
        foreach ($items as $product) {
            $p = $xaml->addChild($childKey);
            if (!is_array($product)) {
                $product = $product->toArray();
            }
            foreach ($product as $prop => $value) {
                if (!empty($value)) {
                    $p->addChild($prop,  $value);
                }
            }
        }


        $dom = dom_import_simplexml($xaml)->ownerDocument;
        $dom->encoding = 'UTF-8';
        $dom->formatOutput = true;

        return $dom->saveXML();

//        $dom = new DOMDocument('1.0', 'UTF-8');
//        $dom->preserveWhiteSpace = false;
//        $dom->formatOutput = true;
//        $dom->loadXML($xaml->asXML());
//        $xml_string = $dom->saveXML();
//        return preg_replace('/^  |\G  /m', '    ', $xml_string);
    }
}