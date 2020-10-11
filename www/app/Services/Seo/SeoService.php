<?php

namespace App\Services\Seo;

class SeoService
{

    public function __construct()
    {

    }

    public function formTitleAndDescriptionShowArt(int $artId): array
    {
        $title = 'Art #' . $artId . ' | Drawitbook.ru';
        $description = 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.';
        return [$title, $description];
    }

    public function createCategoryTitle(string $category, string $subcategory, int $countResults)
    {
        $countPostfix = $this->formCategoryCountPostfix($countResults);
        return implode(' ', [$category, frenchQuotes($subcategory), '☆']) . ($countPostfix ? ' ': '') . $countPostfix;
    }

    public function createCategoryDescription(string $category, string $subcategory, int $countResults)
    {
        $parts = [
            $subcategory,
        ];
        $countPostfix = $this->formCategoryCountPostfix($countResults);
        if (!empty($countPostfix)) {
            $parts[] = $countPostfix;
        }
        $parts[] = 'Схемы чёрно-белых и цветных рисунков от легких и простых до сложных';
        return $category . ' ✎ ' . implode(' ➣ ', $parts) . '.';
    }

    private static function formCategoryCountPostfix(int $countResults): string
    {
        $countPostfix = '';
        if ($countResults > 10) {
            $countPostfix = pluralForm($countResults, ['рисунок', 'рисунка', 'рисунков']);
        }
        return $countPostfix;
    }
}


