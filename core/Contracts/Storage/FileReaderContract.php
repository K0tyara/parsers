<?php

namespace Core\Contracts\Storage;

interface FileReaderContract
{
    public function read(string $path): string;
    public function readAllLines(string $path): array;
}