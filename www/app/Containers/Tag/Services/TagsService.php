<?php

namespace App\Containers\Tag\Services;

use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsByPictureIdsTask;
use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsNamesWithoutHiddenVkByPictureIdTask;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Tasks\GetTagsByIdsWithFlagsTask;
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

    public function getTagsByArtIds(array $artIds, bool $withHidden): array
    {
        $locale = app()->getLocale();
        return app(GetPictureTagsByPictureIdsTask::class)->run($artIds, $withHidden, $locale);
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

    public function extractNotHiddenTagNamesFromArt(array $art): array
    {
        $result = [];
        if (!empty($art['tags'])) {
            foreach ($art['tags'] as $tag) {
                if (!in_array(FlagsEnum::TAG_HIDDEN, $tag['flags'], true)) {
                    $result[] = $tag[SprTagsColumnsEnum::NAME];
                }
            }
        }
        return $result;
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
        $tagIds = array_column($artTags, 'tag_id');
        if (!empty($tagIds)) {
            $tags = app(GetTagsByIdsWithFlagsTask::class)->run($tagIds);
            foreach ($tags as $tag) {
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

