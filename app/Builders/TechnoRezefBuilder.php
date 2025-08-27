<?php

namespace App\Builders;

use App\Enums\ParserList;
use App\Services\ParserContainer;
use App\Services\ParserTimeSleepContainer;
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

        $sleepContainer = new ParserTimeSleepContainer();
        return new ParserContainer(
            $parserName,
            $parser,
            $sleepContainer,
            new SaveHandler(new XamlFormatter())
        );

    }
}