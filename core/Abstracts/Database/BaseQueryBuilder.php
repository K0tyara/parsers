<?php

namespace Core\Abstracts\Database;

use PDO;

abstract class BaseQueryBuilder
{
    public function __construct(
        protected PDO $pdo
    )
    {
    }
}