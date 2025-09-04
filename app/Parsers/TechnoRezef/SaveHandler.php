<?php

namespace App\Parsers\TechnoRezef;

use App\Contracts\ParserResultSaverContract;
use App\Facades\Xaml;
use Core\Contracts\Formatters\FormatterContract;
use Core\Facades\FileWriter;
use Core\Facades\Storage;

final readonly class SaveHandler implements ParserResultSaverContract
{
    public function __construct(
        private ?FormatterContract $formatterContract = null)
    {

    }


    public function save(string $name, array $value): void
    {
        $content = Xaml::convert($value, formatterContract: $this->formatterContract);
        $resultStorage = Storage::disk('results');

        if ($content) {
            FileWriter::put("{$resultStorage->getPath()}/$name.xml", $content);
        }
    }
}