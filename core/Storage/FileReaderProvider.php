<?php

namespace Core\Storage;

use Core\Contracts\Storage\FileReaderContract;

class FileReaderProvider implements FileReaderContract
{
    public function read(string $path): string
    {
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return '';
    }

    public function readAllLines(string $path): array
    {
        $text = $this->read($path);

        return explode("\r\n", $text);
    }
}