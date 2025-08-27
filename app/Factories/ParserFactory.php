<?php

namespace App\Factories;

use App\Builders\TechnoRezefBuilder;
use App\Enums\ParserList;
use App\Services\ParserContainer;
use LogicException;

final readonly class ParserFactory
{
    public static function make(ParserList $parser): ?ParserContainer
    {
        return match ($parser) {
            ParserList::TechnoRezef => TechnoRezefBuilder::build(),
            default => throw new LogicException("Builder for parser \"$parser->value\" not exist.")
        };
    }
}