<?php

namespace App\Factories;

use App\Builders\TechnoRezefBuilder;
use App\Enums\ParserList;
use App\Services\ParserContainer;

final readonly class ParserFactory
{
    public static function make(ParserList $parser): ?ParserContainer
    {
        return match ($parser) {
            ParserList::TechnoRezef => TechnoRezefBuilder::build(),
            default => null
        };
    }
}