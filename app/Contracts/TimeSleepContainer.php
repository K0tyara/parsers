<?php

namespace App\Contracts;

interface TimeSleepContainer
{
    public function sleepAfterParseProductPage(): void;

    public function sleepAfterParseProduct(): void;
}