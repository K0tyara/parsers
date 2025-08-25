<?php

namespace Core\Database\Builders;

use Core\Contracts\Database\QueryBuilderContract;
use Core\Database\MySQL\MySQLDatabaseProvider;
use Core\Database\MySQL\MysqlQueryBuilder;

final readonly class MysqlConnectionBuilder
{

    public static function build(string $host, string $database, string $user, string $password): QueryBuilderContract
    {
        $provider = new MySQLDatabaseProvider($host, $database, $user, $password);

        return new MysqlQueryBuilder($provider->connect());
    }
}