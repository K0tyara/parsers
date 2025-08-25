<?php

namespace Core\Contracts\Storage;

interface FileWriterContract
{
    public function put(string $fullPath, string $content): bool;

    public function append(string $fullPath, string $content): bool;
    public function appendLine(string $fullPath, string $content): bool;
}