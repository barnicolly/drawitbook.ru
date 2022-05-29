<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $hidden
 * @property int $hidden_vk
 * @property string $seo
 * @property string $slug_en
 * @property string $is_popular
 */
class SprTagsModel extends CoreModel
{
    protected $table = SprTagsColumnsEnum::TABlE;

    public $timestamps = false;

    protected $fillable = [
        SprTagsColumnsEnum::NAME,
    ];

    public static function getBySeoName(string $tagSeoName, string $locale): ?array
    {
        if ($locale === LangEnum::EN) {
            $select = [
                SprTagsColumnsEnum::ID,
                SprTagsColumnsEnum::NAME_EN . ' as name',
                SprTagsColumnsEnum::SLUG_EN . ' as seo',
            ];
        } else {
            $select = [
                SprTagsColumnsEnum::ID,
                SprTagsColumnsEnum::NAME,
                SprTagsColumnsEnum::SEO,
            ];
        }
        $result = self::query()
            ->select($select)
            ->where(
                function ($query) use ($tagSeoName, $locale) {
                    if ($locale === LangEnum::EN) {
                        $query->where(SprTagsColumnsEnum::SLUG_EN, $tagSeoName);
                    }
                    if ($locale === LangEnum::RU) {
                        $query->where(SprTagsColumnsEnum::SEO, $tagSeoName);
                    }
                }
            )
            ->getQuery()
            ->first();
        if ($result) {
            return (array) $result;
        }
        return null;
    }

    public static function getById(int $id): ?array
    {
        $result = self::query()
            ->where(SprTagsColumnsEnum::ID, '=', $id)
            ->getQuery()
            ->first();
        return $result
            ? (array) $result
            : null;
    }
}
