<?php

namespace Core\Database\MySQL;

use Core\Abstracts\Database\BaseQueryBuilder;
use Core\Contracts\Database\QueryBuilderContract;
use LogicException;
use PDO;

class MysqlQueryBuilder extends BaseQueryBuilder implements QueryBuilderContract
{
    private string $table = '';
    private array $columns = ['*'];
    private array $wheres = [];
    private array $bindings = [];

    public function table(string $table): QueryBuilderContract
    {
        $this->table = $table;
        return $this;
    }

    public function select(array $columns = ['*']): QueryBuilderContract
    {
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, string $operator, mixed $value): QueryBuilderContract
    {
        $this->wheres[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function get(): array
    {
        $sql = sprintf(
            'SELECT %s FROM `%s`%s',
            implode(', ', $this->columns),
            $this->table,
            $this->wheres ? ' WHERE ' . implode(' AND ', $this->wheres) : ''
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->reset();

        return $result;
    }

    public function first(): ?array
    {
        $sql = sprintf(
            'SELECT %s FROM `%s`%s LIMIT 1',
            implode(', ', $this->columns),
            $this->table,
            $this->wheres ? ' WHERE ' . implode(' AND ', $this->wheres) : ''
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->reset();
        return $result ?: null;
    }

    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = rtrim(str_repeat('?, ', count($data)), ', ');

        $sql = "INSERT INTO `$this->table` ($columns) VALUES ($placeholders)";
        //INSERT INTO `reviews` (user_name, rating, title) VALUES (?, ?, ?)

        $stmt = $this->pdo->prepare($sql);

        $result = $stmt->execute(array_values($data));
        $this->reset();

        return $result;
    }

    public function update(array $data): bool
    {
        throw  new LogicException("Method Update not implement");
    }

    public function delete(): bool
    {
        throw  new LogicException("Method Delete not implement");
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    private function reset(): void
    {
        $this->table = '';
        $this->columns = ['*'];
        $this->wheres = [];
        $this->bindings = [];
    }
}