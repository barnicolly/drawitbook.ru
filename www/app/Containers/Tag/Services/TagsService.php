<?php

namespace App\Containers\Tag\Services;

use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsNamesWithoutHiddenVkByPictureIdTask;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Services\Route\RouteService;

class TagsService
{
    //    todo-misha вынести в модуль picture все что связано с ними, оставить только получение справочных данных;

    private RouteService $routeService;

    public function __construct()
    {
        $this->routeService = app(RouteService::class);
    }

    public function getNamesWithoutHiddenVkByArtId(int $artId): array
    {
        return app(GetPictureTagsNamesWithoutHiddenVkByPictureIdTask::class)->run($artId);
    }

    public function setLinkOnTags(array $tags): array
    {
        foreach ($tags as $key => $tag) {
            $tags[$key]['link'] = $this->routeService->getRouteArtsCellTagged($tag['seo']);
            $tagName = mbUcfirst($tag['name']);
            $prefix = __('common.pixel_arts');
            $tags[$key]['link_title'] = "{$prefix} «{$tagName}»";
        }
        return $tags;
    }

    /**
     * @param array $artTags
     * @return array{array,array}
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function separateTagsForHiddenAndShowIds(array $artTags): array
    {
        $hidden = [];
        $shown = [];
        if (!empty($artTags)) {
            foreach ($artTags as $tag) {
                if (in_array(FlagsEnum::TAG_HIDDEN, $tag['flags'], true)) {
                    $hidden[] = $tag[SprTagsColumnsEnum::ID];
                } else {
                    $shown[] = $tag[SprTagsColumnsEnum::ID];
                }
            }
        }
        return [$shown, $hidden];
    }

}

