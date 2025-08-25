<?php


return [
    'default' => $_ENV['DATABASE_PROVIDER'],
    #важный порядок - параметры в фабриках и билдерах передаются через распаковку массива
    'mysql' => [
        'host' => $_ENV['DATABASE_HOST'],
        'database' => $_ENV['DATABASE_NAME'],
        'user' => $_ENV['DATABASE_USER'],
        'password' => $_ENV['DATABASE_PASSWORD']
    ]
];