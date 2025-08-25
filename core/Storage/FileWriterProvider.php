<?php

namespace Core\Storage;

use Core\Contracts\Storage\FileWriterContract;

class FileWriterProvider implements FileWriterContract
{

    public function put(string $fullPath, string $content): bool
    {
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents($fullPath, $content) !== false;
    }

    public function append(string $fullPath, string $content): bool
    {
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return file_put_contents($fullPath, $content, FILE_APPEND) !== false;
    }

    public function appendLine(string $fullPath, string $content): bool
    {
        return $this->append($fullPath, "$content\n");
    }
}