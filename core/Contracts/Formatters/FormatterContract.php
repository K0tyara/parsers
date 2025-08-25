<?php

namespace Core\Contracts\Formatters;

interface FormatterContract
{
    public function format(array $items): array;
}