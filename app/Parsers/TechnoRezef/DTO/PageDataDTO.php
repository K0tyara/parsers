<?php

namespace App\Parsers\TechnoRezef\DTO;

use App\Abstracts\Page;
use App\Parsers\TechnoRezef\TechnoRezefCom;

final readonly class PageDataDTO extends Page
{
    public function __construct(
        public int $perPage,
        public int $currentPage,
        public int $totalPages,
    )
    {
    }

    public function getPageUrl(): string
    {
        return str_replace('%PAGE%', $this->currentPage, TechnoRezefCom::PREG_SEARCH);
    }

    public function getNextPageUrl(): string
    {
        return str_replace('%PAGE%', $this->currentPage + 1, TechnoRezefCom::PREG_SEARCH);
    }

    public function toArray(): array
    {
        return [
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'total_page' => $this->totalPages
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['per_page'],
            $data['current_page'],
            $data['total_page'],
        );
    }

}