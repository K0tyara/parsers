<?php

namespace App\TechnoRezef\DTO;

use App\Abstracts\Page;
use App\TechnoRezef\TechnoRezefCom;

final readonly class PageDataDTO extends Page
{
    public function __construct(
        public int $perPage,
        public int $currentPage,
        public int $totalPages,
    )
    {
    }

    public function getNexPage(): string
    {
        $nextPage = $this->currentPage + 1;
        return str_replace('%PAGE%', $nextPage, TechnoRezefCom::PREG_SEARCH);
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