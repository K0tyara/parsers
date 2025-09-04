<?php

namespace App\Services;

use App\Abstracts\ParserServiceBase;
use App\Contracts\ParserResultSaverContract;
use App\Enums\ParserList;
use Throwable;

final readonly class ParserContainer
{
    public function __construct(
        public ParserList                $parserName,
        public ParserServiceBase         $service,
        public ParserResultSaverContract $saver,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function run(): void
    {
        $container = $this->service->execute();
        if ($container->count()) {
            $this->saver->save($this->parserName->value, $container->products());
        }
    }
}