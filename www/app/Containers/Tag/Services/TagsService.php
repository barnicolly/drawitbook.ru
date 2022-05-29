<?php

namespace App\Containers\Tag\Services;

use App\Containers\Picture\Models\PictureTagsModel;
use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Facades\Cache;

class TagsService
{
    //    todo-misha вынести в модуль picture все что связано с ними, оставить только получение справочных данных;

    private $routeService;

    public function __construct()
    {
        $this->routeService = (new RouteService());
    }

    public function getNamesWithoutHiddenVkByArtId(int $artId): array
    {
        return PictureTagsModel::getNamesWithoutHiddenVkByArtId($artId);
    }

    public function getTagsByArtIds(array $artIds, bool $withHidden): array
    {
        $locale = app()->getLocale();
        return PictureTagsModel::getTagsByArtIds($artIds, $withHidden, $locale);
    }

    public function getTagsByArtId(int $artId, bool $withHidden): array
    {
        return $this->getTagsByArtIds([$artId], $withHidden);
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
        $tags = [];
        foreach ($art['tags'] as $tag) {
            if ($tag['hidden'] === 0) {
                $tags[] = mbUcfirst($tag['name']);
            }
        }
        return $tags;
    }

    public function separateTagsForHiddenAndShowIds(array $artTags): array
    {
        $hidden = [];
        $shown = [];
        foreach ($artTags as $tag) {
            if ($tag['hidden'] === 1) {
                $hidden[] = $tag['tag_id'];
            } else {
                $shown[] = $tag['tag_id'];
            }
        }
        return [$shown, $hidden];
    }

    public function extractNotHiddenTagsFromArt(array $artTags): array
    {
        $tags = [];
        foreach ($artTags as $tag) {
            if ($tag['hidden'] === 0) {
                $tags[] = $tag;
            }
        }
        return $tags;
    }

    public function getMostPopular(int $limit, string $locale): array
    {
        $cacheName = $locale . '.spr.tag_cloud';
        $results = Cache::get($cacheName);
        if (!$results) {
            $results = Cache::remember(
                $cacheName,
                config('cache.expiration'),
                function () use ($limit, $locale) {
                    return PictureTagsModel::getTagsWithCountArts($limit, $locale);
                }
            );
        }
        return $results;
    }

    public function getPopular(string $locale): array
    {
        return PictureTagsModel::getPopularTags($locale);
    }

    public function getByTagSeoName(string $tagSeoName, string $locale): ?array
    {
        return SprTagsModel::getBySeoName($tagSeoName, $locale);
    }

    public function getById(int $id): ?array
    {
        return SprTagsModel::getById($id);
    }

}

