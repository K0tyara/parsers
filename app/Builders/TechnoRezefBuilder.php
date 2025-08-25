<?php

namespace App\Builders;

use App\Contracts\ParserContract;
use App\TechnoRezef\Parser;
use Core\Log\Factory\LogFactory;

final readonly class TechnoRezefBuilder
{

    public static function build(): ParserContract
    {
        return new Parser(
            LogFactory::console('techno_rezef')
        );
    }
}