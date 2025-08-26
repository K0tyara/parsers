<?php

namespace Core\Contracts\Convectors;

use Core\Contracts\Formatters\FormatterContract;

interface XamlConvectorContract
{
    /**
     * @param array $items
     * @param string $childKey
     * @param FormatterContract|null $formatterContract
     * @return string
     */
    public function convert(array $items, string $childKey = 'Product', ?FormatterContract $formatterContract = null): string;
}