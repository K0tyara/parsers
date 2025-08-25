<?php

namespace Core\Contracts\Convectors;

use Core\Contracts\Formatters\FormatterContract;

interface XamlConvectorContract
{
    /**
     * @param array $items
     * @param FormatterContract|null $formatterContract
     * @return string
     */
    public function convert(array $items, ?FormatterContract $formatterContract = null): string;
}