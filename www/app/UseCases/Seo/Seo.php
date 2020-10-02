<?php

namespace App\UseCases\Seo;

class Seo
{

    public function __construct()
    {

    }

    public static function createCategoryTitle(string $category, string $subcategory, int $countResults)
    {
        $countPostfix = '';
        if ($countResults > 10) {
            $countPostfix = ' ' . pluralForm($countResults, ['рисунок', 'рисунка', 'рисунков']);
        }
        return implode(' ', [$category, frenchQuotes($subcategory), '☆']) . $countPostfix;
    }

    public static function createCategoryDescription(string $category, string $subcategory, int $countResults)
    {
        $countPostfix = '';
        if ($countResults > 10) {
            $countPostfix = pluralForm($countResults, ['рисунок', 'рисунка', 'рисунков']);
        }
        return $category . ' ✎ ' . implode(' ➣ ', [$subcategory, $countPostfix, 'Схемы чёрно-белых и цветных рисунков от легких и простых до сложных']) . '.';
    }
}
