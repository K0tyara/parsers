<?php

namespace App\Parsers\TechnoRezef\Normalizers;

class ProductCardNormalizer
{

    public static function normalize(array $elements): array
    {
        $results = [];
        foreach ($elements as $element) {
            $element = pq($element);
            $href = $element->find('.card__media a')->attr('href');
            $title = $element->find('.card__media a')->attr('aria-label');

            $status = trim($element->find('[data-inventory-level]')->attr('data-inventory-level'));
            if (!$status) {
                $status = trim($element->find('[style*=data-inventory-level]')->text());
            }
            $imageData = $element->find('img[data-srcset]')->attr('data-srcset');

            $images = array_map(
                fn($part) => trim(explode(' ', trim($part))[0]),
                explode(',', $imageData)
            );

            $results[] = [
                'href' => $href,
                'title' => $title,
                'images' => $images,
                'status' => $status
            ];
        }

        return $results;
    }
}