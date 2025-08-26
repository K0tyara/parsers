<?php

use App\Enums\ParserList;
use App\Factories\ParserFactory;
use App\Services\ParserService;
use Core\Log\Factory\LogFactory;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

$parserName = ParserList::TechnoRezef;

$mainLog = LogFactory::console('main');

try {
    $container = ParserFactory::make($parserName);
    if ($container == null) {
        return;
    }

    $parserHandler = new ParserService(
        $parserName->value,
        $container->handler
    );

    $container->run($parserHandler);


} catch (Throwable $ex) {
    $mainLog->error($ex);
}