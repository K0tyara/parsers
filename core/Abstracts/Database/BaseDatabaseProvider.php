<?php

namespace Core\Abstracts\Database;
abstract readonly class BaseDatabaseProvider
{
    public function __construct(
        protected string $host,
        protected string $database,
        protected string $username,
        protected string $password,
    )
    {
    }
}