<?php

use App\Enums\ParserList;
use App\Factories\ParserFactory;
use Core\Log\Factory\LogFactory;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

//$args = getopt("", ["name::"]);
//
//if (!isset($args['name'])) {
//    throw  new LogicException("Argument --name is required");
//}
//
//$parserName = ParserList::fromValue($args['name']);

$parserName = ParserList::CableCoIl;
$mainLog = LogFactory::console("main-$parserName->value");

try {
    $container = ParserFactory::make($parserName);
    if ($container == null) {
        return;
    }

    $mainLog->info("Start parsing.");
    $container->run();
    $mainLog->info("End parsing.");

} catch (Throwable $ex) {
    $mainLog->error($ex);
}