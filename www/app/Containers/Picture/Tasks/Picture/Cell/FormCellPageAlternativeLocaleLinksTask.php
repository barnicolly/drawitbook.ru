<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\Picture\Cell;

use App\Containers\Tag\Data\Dto\TagDto;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;

final class FormCellPageAlternativeLocaleLinksTask extends Task
{
    public function __construct(private readonly RouteService $routeService)
    {
    }

    public function run(TagDto $tag): array
    {
        $forFormAlternateLinks = [];
        $forFormAlternateLinks[] = [
            'lang' => $tag->seo_lang->current->locale->value,
            'tag' => $tag->seo_lang->current->slug,
        ];
        if (!empty($tag->seo_lang->alternative->slug)) {
            $forFormAlternateLinks[] = [
                'lang' => $tag->seo_lang->alternative->locale->value,
                'tag' => $tag->seo_lang->alternative->slug,
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
