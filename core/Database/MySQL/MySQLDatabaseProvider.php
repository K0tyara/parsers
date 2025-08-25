<?php

namespace Core\Database\MySQL;

use Core\Abstracts\Database\BaseDatabaseProvider;
use Core\Contracts\Database\DatabaseProviderContract;
use PDO;

readonly class MySQLDatabaseProvider extends BaseDatabaseProvider implements DatabaseProviderContract
{
    public function connect(): PDO
    {
        $this->createDatabaseIfNotExists();

        $dsn = "mysql:host={$this->host};dbname={$this->database};";

        #ATTR_ERRMODE      - PDO выбросит исключение PDOException (если таблица не существует)
        #ERRMODE_EXCEPTION - При возникновении ошибки выдать исключение PDOException

        return new PDO($dsn, $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    private function createDatabaseIfNotExists(): void
    {
        $pdo = new PDO("mysql:host={$this->host};charset=utf8mb4", $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$this->database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    public function getDriver(): string
    {
        return 'mysql';
    }
}