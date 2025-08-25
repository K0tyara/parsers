<?php

use App\Enums\ParserList;
use App\Facades\Xaml;
use App\Factories\ParserFactory;
use App\Services\ParserService;
use Core\Facades\FileWriter;
use Core\Facades\Storage;
use Core\Log\Factory\LogFactory;
use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

$parserName = ParserList::TechnoRezef;
$resultStorage = Storage::disk('results');
$mainLog = LogFactory::console('main');

try {
    $parser = ParserFactory::make($parserName);
    if ($parser == null) {
        return;
    }

    $parserHandler = new ParserService(
        $parserName->value,
        $parser
    );

    $products = $parserHandler->parse();

    $xaml = Xaml::convert($products->products(), $parser->getFormatter());

    if ($xaml) {
        FileWriter::put("{$resultStorage->getDiskPath()}/{$parserName->value}.xml", $xaml);
    }


} catch (Throwable $ex) {
    $mainLog->error($ex);
}