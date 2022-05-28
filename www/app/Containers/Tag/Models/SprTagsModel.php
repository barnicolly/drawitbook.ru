<?php

namespace App\Containers\Tag\Models;

use App\Containers\Translation\Enums\LangEnum;
use App\Models\CoreModel;

class SprTagsModel extends CoreModel
{
    protected $table = 'spr_tags';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getBySeoName(string $tagSeoName, string $locale): ?array
    {
        if ($locale === LangEnum::EN) {
            $select = [
                'id',
                'name_en as name',
                'slug_en as seo',
            ];
        } else {
            $select = [
                'id',
                'name',
                'seo',
            ];
        }
        $result = self::query()
            ->select($select)
            ->where(
                function ($query) use ($tagSeoName, $locale) {
                    if ($locale === LangEnum::EN) {
                        $query->where('slug_en', $tagSeoName);
                    }
                    if ($locale === LangEnum::RU) {
                        $query->where('seo', $tagSeoName);
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
            ->where('id', '=', $id)
            ->getQuery()
            ->first();
        return $result
            ? (array) $result
            : null;
    }
}
