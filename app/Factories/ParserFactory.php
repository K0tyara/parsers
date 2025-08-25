<?php

namespace App\Factories;

use App\Builders\TechnoRezefBuilder;
use App\Contracts\ParserContract;
use App\Enums\ParserList;

final readonly class ParserFactory
{
    public static function make(ParserList $parser): ?ParserContract
    {
        return match ($parser) {
            ParserList::TechnoRezef => TechnoRezefBuilder::build(),
            default => null
        };
    }
}