<?php

namespace App\Abstracts;

readonly abstract class Product
{
    public string $link;
    public string $code;
    public string $title;
    public string $description;
    public string $price;
    public string $status;
    public string $html;
    public array $categories;
    public array $images;
    public array $extra;

    public abstract function toArray(): array;
}