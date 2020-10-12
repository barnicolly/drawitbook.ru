<?php

namespace App\Services\Seo;

use App\Entities\Picture\PictureModel;
use App\Services\Tags\TagsService;

class SeoService
{

    public function formTitleAndDescriptionShowArt(int $artId): array
    {
        $title = 'Art #' . $artId . ' | Drawitbook.ru';
        $description = 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.';
        return [$title, $description];
    }

    public function createCategoryTitle(string $category, string $subcategory, int $countResults): string
    {
        $countPostfix = $this->formCategoryCountPostfix($countResults);
        return implode(' ', [$category, frenchQuotes($subcategory), '☆']) . ($countPostfix ? ' ': '') . $countPostfix;
    }

    public function createCategoryDescription(string $category, string $subcategory, int $countResults): string
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

    public function setArtAlt(PictureModel $art): void
    {
        $tags = (new TagsService)->extractTagsFromArt($art);
        if ($tags) {
            $art->alt = 'Рисунки по клеточкам ➣ ' . implode(' ➣ ', $tags);
        }
    }

    private function formCategoryCountPostfix(int $countResults): string
    {
        $countPostfix = '';
        if ($countResults > 10) {
            $countPostfix = pluralForm($countResults, ['рисунок', 'рисунка', 'рисунков']);
        }
        return $countPostfix;
    }
}


