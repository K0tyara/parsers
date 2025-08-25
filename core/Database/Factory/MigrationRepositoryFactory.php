<?php

namespace Core\Database\Factory;

use Core\Contracts\Database\MigrationRepositoryContract;
use Core\Database\MySQL\MysqlMigrationRepository;
use PDO;

final class MigrationRepositoryFactory
{
    public static function get(PDO $pdo): MigrationRepositoryContract
    {
        $provider = config('database.default');

        return match ($provider) {
            'mysql' => new MysqlMigrationRepository($pdo)
        };
    }
}