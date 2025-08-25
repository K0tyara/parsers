<?php

namespace App\Abstracts;

readonly abstract class Page
{
    public int $currentPage;

    public abstract function getNextPageUrl(): string;
    public abstract function getPageUrl(): string;
}