<?php

namespace App\Containers\Picture\Models;

use App\Entities\Spr\SprTagsModel;
use App\Enums\Lang;
use App\Models\CoreModel;
use Illuminate\Support\Facades\DB;

class PictureTagsModel extends CoreModel
{
    protected $table = 'picture_tags';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getNamesWithoutHiddenVkByArtId(int $artId): array
    {
        $query = self::query();
        return $query->where('picture_id', $artId)
            ->where('spr_tags.hidden_vk', 0)
            ->join('spr_tags', 'spr_tags.id', '=', 'picture_tags.tag_id')
            ->getQuery()
            ->get()
            ->pluck('name')
            ->toArray();
    }

    public static function getTagsByArtIds(array $artIds, bool $withHidden, string $locale): array
    {
        $query = self::query();
        if ($locale === Lang::EN) {
            $select = [
                'picture_tags.id',
                'picture_tags.picture_id',
                'picture_tags.tag_id',
                'spr_tags.hidden',
                'spr_tags.hidden_vk',
                'spr_tags.name_en as name',
                'spr_tags.slug_en as seo',
            ];
        } else {
            $select = [
                'picture_tags.id',
                'picture_tags.picture_id',
                'picture_tags.tag_id',
                'spr_tags.hidden',
                'spr_tags.hidden_vk',
                'spr_tags.name',
                'spr_tags.seo',
            ];
        }
        $result = $query->whereIn('picture_id', $artIds)
            ->select($select)
            ->join('spr_tags', 'spr_tags.id', '=', 'picture_tags.tag_id')
            ->where(
                function ($query) use ($withHidden) {
                    if (!$withHidden) {
                        $query->where('spr_tags.hidden', '=', 0);
                    }
                }
            )
            ->where(
                function ($query) use ($locale) {
                    if ($locale === Lang::EN) {
                        $query->whereNotNull('spr_tags.slug_en');
                    }
                }
            )
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

    public static function getTagsWithCountArts(int $limit, string $locale): array
    {
        $locale = mb_strtolower($locale);
        $query = SprTagsModel::query();
        if ($locale === Lang::EN) {
            $select = [
                'spr_tags.name_en as name',
                'spr_tags.slug_en as seo',
                DB::raw("count(\"picture_tags.id\") as count"),
            ];
        } else {
            $select = [
                'spr_tags.name',
                'spr_tags.seo',
                DB::raw("count(\"picture_tags.id\") as count"),
            ];
        }
        $result = $query
            ->select($select)
            ->where(
                function ($query) use ($locale) {
                    if ($locale === Lang::EN) {
                        $query->whereNotNull('spr_tags.slug_en');
                    }
                }
            )
            ->where('spr_tags.hidden', 0)
            ->join('picture_tags', 'picture_tags.tag_id', '=', 'spr_tags.id')
            ->groupBy('spr_tags.id')
            ->orderBy('count', 'desc')
            ->take($limit)
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

    public static function getPopularTags(string $locale): array
    {
        $locale = mb_strtolower($locale);
        $query = SprTagsModel::query();
        if ($locale === Lang::EN) {
            $select = [
                'spr_tags.name_en as name',
                'spr_tags.slug_en as seo',
            ];
        } else {
            $select = [
                'spr_tags.name',
                'spr_tags.seo',
            ];
        }
        $result = $query
            ->select($select)
            ->where(
                function ($query) use ($locale) {
                    if ($locale === Lang::EN) {
                        $query->whereNotNull('spr_tags.slug_en');
                    }
                }
            )
            ->where('spr_tags.is_popular', 1)
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

    public static function getTagsForSitemap(): array
    {
        $query = SprTagsModel::query();
        $select = [
            'spr_tags.*',
        ];
        $result = $query
            ->select($select)
            ->join('picture_tags', 'picture_tags.tag_id', '=', 'spr_tags.id')
            ->join('picture', 'picture.id', '=', 'picture_tags.picture_id')
            ->where('picture.is_del', 0)
            ->groupBy('spr_tags.id')
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }
}
