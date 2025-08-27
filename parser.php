<?php

use App\Enums\ParserList;
use App\Factories\ParserFactory;
use App\Services\ParserService;
use Core\Log\Factory\LogFactory;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

$args = getopt("", ["name::"]);

if (!isset($args['name'])) {
    throw  new LogicException("Argument --name is required");
}

$parserName = ParserList::fromValue($args['name']);
$mainLog = LogFactory::console("main-$parserName->value");

try {
    $container = ParserFactory::make($parserName);
    if ($container == null) {
        return;
    }

    $parserHandler = new ParserService(
        $parserName->value,
        $container->handler,
        $container->sleepContainer,
        $container->withSnapshot
    );

    $mainLog->info("Start parsing.");
    $container->run($parserHandler);
    $mainLog->info("End parsing.");

} catch (Throwable $ex) {
    $mainLog->error($ex);
}