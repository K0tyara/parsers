<?php

namespace Core\Database\Factory;

use Core\Contracts\Database\QueryBuilderContract;
use Core\Database\Builders\MysqlConnectionBuilder;
use LogicException;

final class QueryBuilderFactory
{
    #простой кеш для что бы не переподключиться каждый раз
    #можно переделать на массив что бы сохранять несколько подключений
    private static ?QueryBuilderContract $instance = null;

    public static function get(): QueryBuilderContract
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        $provider = config('database.default');

        if ($provider == null) {
            throw new LogicException("Database provider not set.");
        }
        $config = config("database.$provider");

        if (!is_array($config)) {
            throw new LogicException("Invalid database configuration for provider $provider.");
        }

        $builder = match ($provider) {
            'mysql' => MysqlConnectionBuilder::build(...$config)
        };

        self::$instance = $builder;

        return $builder;
    }
}