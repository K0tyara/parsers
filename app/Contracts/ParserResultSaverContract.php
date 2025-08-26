<?php

namespace App\Contracts;

interface ParserResultSaverContract
{
    public function save(string $name, array $value): void;
}