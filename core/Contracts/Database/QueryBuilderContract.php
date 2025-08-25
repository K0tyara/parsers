<?php

namespace Core\Contracts\Database;

use PDO;

interface QueryBuilderContract
{
    public function table(string $table): self;

    public function select(array $columns = ['*']): self;

    public function where(string $column, string $operator, mixed $value): self;

    public function get(): array;

    public function first(): ?array;

    public function insert(array $data): bool;

    public function update(array $data): bool;

    public function delete(): bool;

    public function getConnection(): PDO;
}