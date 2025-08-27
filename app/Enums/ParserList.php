<?php

namespace App\Enums;

use LogicException;

enum ParserList: string
{
    case TechnoRezef = 'techno-rezef';

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'techno-rezef' => ParserList::TechnoRezef,
            default => throw new LogicException("Parser \"$value\" not exist")
        };
    }
}