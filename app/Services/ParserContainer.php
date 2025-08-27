<?php

namespace App\Services;

use App\Contracts\ParserContract;
use App\Contracts\ParserResultSaverContract;
use App\Enums\ParserList;
use Throwable;

final readonly class ParserContainer
{
    public function __construct(
        public ParserList                $parserName,
        public ParserContract            $handler,
        public ParserTimeSleepContainer  $sleepContainer,
        public ParserResultSaverContract $saver,
        public bool                      $withSnapshot = false,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function run(ParserService $service): void
    {
        $container = $service->parse();
        if ($container->count()) {
            $this->saver->save($this->parserName->value, $container->products());
        }
    }
}