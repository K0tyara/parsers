<?php

namespace App\Abstracts;

readonly abstract class Page
{
    public int $currentPage;

    public abstract function getNexPage(): string;
}