<?php

namespace App\Builders;

use App\Enums\ParserList;
use App\Services\ParserContainer;
use App\TechnoRezef\Formatters\XamlFormatter;
use App\TechnoRezef\Parser;
use App\TechnoRezef\SaveHandler;
use Core\Log\Factory\LogFactory;

final readonly class TechnoRezefBuilder
{

    public static function build(): ParserContainer
    {
        $parserName = ParserList::TechnoRezef;
        $parser = new Parser(
            LogFactory::console($parserName->value)
        );

        return new ParserContainer(
            $parserName,
            $parser,
            new SaveHandler(new XamlFormatter())
        );

    }
}