<?php

namespace Core\Contracts\Database;

use PDO;

interface DatabaseProviderContract
{
    public function connect(): PDO;

    public function getDriver(): string;
}