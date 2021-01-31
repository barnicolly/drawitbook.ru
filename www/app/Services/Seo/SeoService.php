<?php

namespace App\Services\Seo;

use App\Services\Tags\TagsService;

class SeoService
{

    //TODO-misha перевести seo;

    public function formTitleAndDescriptionShowArt(int $artId): array
    {
        $title = 'Art #' . $artId . ' | Drawitbook.ru';
        $description = 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.';
        return [$title, $description];
    }

    public function formCellTaggedTitleAndDescription(int $countSearchResults, string $tagName): array
    {
        $tagName = mbUcfirst($tagName);
        $prefix = 'Рисунки по клеточкам';
        $title = $this->createCategoryTitle($prefix, $tagName, $countSearchResults);
        $description = $this->createCategoryDescription($prefix, $tagName, $countSearchResults);
        return [$title, $description];
    }

    public function formTitleAndDescriptionCellIndex(): array
    {
        $title = 'Рисунки по клеточкам | Drawitbook.ru';
        $description = 'Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
        return [$title, $description];
    }

    public function formTitleAndDescriptionHome(): array
    {
        $title =  'Drawitbook.ru - рисуйте, развлекайтесь, делитесь с друзьями';
        $description = 'Главное при рисовании по клеточкам придерживаться пропорций будущей картинки. У вас обязательно всё получится.';
        return [$title, $description];
    }

    private function createCategoryTitle(string $category, string $subcategory, int $countResults): string
    {
        $countPostfix = $this->formCategoryCountPostfix($countResults);
        return implode(' ', [$category, frenchQuotes($subcategory), '☆']) . ($countPostfix ? ' ' : '') . $countPostfix;
    }

    private function createCategoryDescription(string $category, string $subcategory, int $countResults): string
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

    public function setArtAlt(array $art): array
    {
        $prefix = __('common.pixel_arts');
        $tags = (new TagsService)->extractNotHiddenTagNamesFromArt($art);
        $art['alt'] = $tags
            ? $prefix . " ➣ " . implode(' ➣ ', $tags)
            : $prefix;
        return $art;
    }

    public function setArtsAlt(array $arts): array
    {
        foreach ($arts as $index => $art) {
            $arts[$index] = $this->setArtAlt($art);
        }
        return $arts;
    }

    public function formCategoryCountPostfix(int $countResults): string
    {
        $countPostfix = '';
        if ($countResults > 10) {
            $countPostfix = pluralForm($countResults, ['рисунок', 'рисунка', 'рисунков']);
        }
        return $countPostfix;
    }
}


