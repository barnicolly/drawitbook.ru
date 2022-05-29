<?php

namespace App\Containers\Seo\Services;

use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;

class SeoService
{

//    todo-misha вынести в контроллеры;
    public function formTitleAndDescriptionSearch(): array
    {
        $title = __('seo.search.title');
        return [$title];
    }

    public function formTitleAndDescriptionShowArt(int $artId): array
    {
        $title = 'Art #' . $artId . ' | Drawitbook.com';
        $description = __('seo.art.description');
        return [$title, $description];
    }

    public function formCellTaggedTitleAndDescription(int $countSearchResults, string $tagName): array
    {
        $tagName = mbUcfirst($tagName);
        $prefix = __('seo.tagged.prefix');
        $title = $this->createCategoryTitle($prefix, $tagName, $countSearchResults);
        $description = $this->createCategoryDescription($prefix, $tagName, $countSearchResults);
        return [$title, $description];
    }

    public function formTitleAndDescriptionCellIndex(): array
    {
        $title = __('seo.cell_index.prefix') . ' | Drawitbook.com';
        $description = __('seo.cell_index.description');
        return [$title, $description];
    }

    public function formTitleAndDescriptionHome(): array
    {
        $title = 'Drawitbook.com - ' . __('seo.home.title');
        $description = __('seo.home.description');
        return [$title, $description];
    }

    private function createCategoryTitle(string $category, string $subcategory, int $countResults): string
    {
        $countPostfix = $this->formCategoryCountPostfix($countResults);
        return implode(' ', [$category, frenchQuotes($subcategory)]) . ($countPostfix ? ' ☆ ' : '') . $countPostfix;
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
        $parts[] = __('seo.tagged.description_part');
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
            $locale = app()->getLocale();
            $countPostfix = (new TranslationService())->getPluralForm($countResults, LangEnum::fromValue($locale));
        }
        return $countPostfix;
    }
}

