<?php

namespace Core\Contracts\Database;

interface MigrationRepositoryContract
{
    public function ensureTable(): void;

    public function getApplied(): array;

    public function log(string $migration): void;
}