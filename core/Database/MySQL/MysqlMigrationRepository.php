<?php

namespace Core\Database\MySQL;

use Core\Abstracts\Database\BaseMigrationRepository;
use Core\Contracts\Database\MigrationRepositoryContract;
use PDO;

readonly class MysqlMigrationRepository extends BaseMigrationRepository implements MigrationRepositoryContract
{

    /**
     * Проверка существует ли таблица с миграциями, если нет - создает ее
     * @return void
     */
    public function ensureTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");
    }

    /**
     * Вернуть все примененные миграции
     * @return array
     */
    public function getApplied(): array
    {
        $stmt = $this->pdo->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Сохраняет примененные миграции (имя файла)
     * @param string $migration
     * @return void
     */
    public function log(string $migration): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migration]);
    }
}