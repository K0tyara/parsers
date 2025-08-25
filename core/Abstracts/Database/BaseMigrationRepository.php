<?php

namespace Core\Abstracts\Database;

use PDO;

readonly abstract class BaseMigrationRepository
{
    public function __construct(
        protected PDO $pdo
    )
    {
    }
}