<?php

namespace App\Builders;

use App\Enums\ParserList;
use App\Parsers\CableCoIl\Parser;
use App\Parsers\CableCoIl\ParserService;
use App\Parsers\Formatters\XamlFormatter;
use App\Parsers\TechnoRezef\SaveHandler;
use App\Services\ParserContainer;
use App\Services\ParserTimeSleepContainer;
use Core\Log\Factory\LogFactory;

final readonly class CableCoIlBuilder
{
    public static function build(): ParserContainer
    {
        $parserName = ParserList::CableCoIl;
        $parser = new Parser(
            LogFactory::console($parserName->value)
        );

        $sleepContainer = new ParserTimeSleepContainer();

        $service = new ParserService(
            $parserName->value,
            $parser,
            $sleepContainer
        );

        return new ParserContainer(
            $parserName,
            $service,
            new SaveHandler(new XamlFormatter())
        );

    }
}