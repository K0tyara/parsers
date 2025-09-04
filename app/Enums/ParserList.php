<?php

namespace App\Enums;

use LogicException;

enum ParserList: string
{
    case TechnoRezef = 'techno-rezef';
    case CableCoIl = 'cable-col-il';

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'techno-rezef' => ParserList::TechnoRezef,
            'cable-col-il' => ParserList::CableCoIl,
            default => throw new LogicException("Parser \"$value\" not exist")
        };
    }
}