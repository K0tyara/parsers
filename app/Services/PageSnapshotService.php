<?php

namespace App\Services;

use App\TechnoRezef\DTO\PageDataDTO;
use Core\Contracts\Storage\StorageContract;
use Core\Facades\FileReader;
use Core\Facades\FileWriter;
use Core\Facades\Storage;

final readonly class PageSnapshotService
{
    private StorageContract $storage;
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->storage = Storage::disk('snapshots');
        $this->fileName = $fileName;
    }


    public function createOrUpdateSnapshot(?PageDataDTO $page): void
    {
        FileWriter::put(
            "{$this->storage->getPath()}/$this->fileName.json",
            json_encode($page ? $page->toArray() : [])
        );
    }

    public function loadLastSnapshot(): ?PageDataDTO
    {
        $fileName = "$this->fileName.json";
        $path = "{$this->storage->getPath()}/$fileName";

        if ($this->storage->isExist($fileName, false)) {
            $data = json_decode(FileReader::read($path), true);
            if ($data) {
                return PageDataDTO::fromArray($data);
            }
        }

        return null;
    }

}