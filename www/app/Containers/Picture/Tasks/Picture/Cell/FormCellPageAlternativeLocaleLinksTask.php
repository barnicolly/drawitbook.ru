<?php

namespace App\Containers\Picture\Tasks\Picture\Cell;

use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;

class FormCellPageAlternativeLocaleLinksTask extends Task
{

    private TagsService $tagsService;
    private RouteService $routeService;

    public function __construct(TagsService $tagsService, RouteService $routeService)
    {
        $this->tagsService = $tagsService;
        $this->routeService = $routeService;
    }

    public function run(string $locale, string $initSlug, int $tagId): array
    {
        $forFormAlternateLinks[] = [
            'lang' => $locale,
            'tag' => $initSlug,
        ];
        $tagInfo = $this->tagsService->getById($tagId);
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;
        $slug = $alternativeLang === LangEnum::RU
            ? $tagInfo['seo']
            : $tagInfo['slug_en'];
        if (!empty($slug)) {
            $forFormAlternateLinks[] = [
                'lang' => $alternativeLang,
                'tag' => $slug,
            ];
            $alternateLinks = $this->getTaggedAlternateLinks($forFormAlternateLinks);
        } else {
            $alternateLinks = [];
        }
        return $alternateLinks;
    }

    private function getTaggedAlternateLinks(array $forFormAlternateLinks): array
    {
        $links = [];
        foreach ($forFormAlternateLinks as $link) {
            $links[] = [
                'lang' => $link['lang'],
                'href' => $this->routeService->getRouteArtsCellTagged($link['tag'], true, $link['lang']),
            ];
        }
        return $links;
    }
}


