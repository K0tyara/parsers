<?php

namespace App\Services;

use Core\Contracts\Http\HttpProviderContract;
use Core\Contracts\Storage\StorageContract;

final readonly class ImageDownloaderService
{
    public function __construct(
        private StorageContract      $storageContract,
        private HttpProviderContract $httpProviderContract,
    )
    {
    }

    /**
     * Скачивает картинку и сохраняет ее на диск
     * @param string $url
     * @return string|bool
     */
    public function download(string $url): string|bool
    {
        $path = $this->storageContract->getRandomPath('png');

        $result = $this->httpProviderContract->download($url, $path);

        if (!$result) {
            $this->storageContract->delete($path);
        }
        return $result ? $path : false;
    }
}