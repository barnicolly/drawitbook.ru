<?php

namespace App\Services\Tags;

use App\Entities\Picture\PictureTagsModel;
use App\Entities\Spr\SprTagsModel;
use App\Services\Route\RouteService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TagsService
{

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
        return PictureTagsModel::getTagsByArtIds($artIds, $withHidden);
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
            $tags[$key]['link_title'] = "Рисунки по клеточкам «{$tagName}»";
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
                $hidden[] = $tag['id'];
            } else {
                $shown[] = $tag['id'];
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

    //TODO-misha отрефакторить;
    public function getMostPopular(int $limit = 40)
    {
        $results = Cache::get('spr.tag_cloud');
        if (!$results) {
            $select = DB::raw(
                "select spr_tags.name, spr_tags.seo, count(picture_tags.id) as c from spr_tags
    join picture_tags on picture_tags.tag_id = spr_tags.id
where hidden = 0
group by spr_tags.id
order by c desc
limit {$limit}"
            );
            $results = Cache::remember(
                'spr.tag_cloud',
                config('cache.expiration'),
                function () use ($select) {
                    return DB::select($select);
                }
            );
        }
        return $results;
    }

    public function getPopular(): array
    {
        return [
            [
                'seo' => 'iz-multfilma',
                'name' => 'Мультфильмы',
            ],
            [
                'seo' => 'zhivotnye',
                'name' => 'Животные',
            ],
            [
                'seo' => 'koshka',
                'name' => 'Кошки',
            ],
            [
                'seo' => 'sobachka',
                'name' => 'Собачки',
            ],
            [
                'seo' => 'supergeroi',
                'name' => 'Супергерои',
            ],
            [
                'seo' => 'edinorog',
                'name' => 'Единороги',
            ],
            [
                'seo' => 'devochka',
                'name' => 'Девочки',
            ],
            [
                'seo' => 'cvety',
                'name' => 'Цветы',
            ],
        ];
    }

    public function getByTagSeoName(string $tagSeoName): array
    {
        return SprTagsModel::getBySeoName($tagSeoName);
    }

}

