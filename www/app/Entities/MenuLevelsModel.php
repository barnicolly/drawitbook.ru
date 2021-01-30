<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MenuLevelsModel extends Model
{
    protected $table = 'menu_levels';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getAll(string $locale): array
    {
        $locale = mb_strtolower($locale);
        $query = self::query();
        $select = [
            'menu_levels.id',
            'menu_levels.parent_level_id',
            'menu_levels.column',
        ];
        if ($locale === 'en') {
            $select = array_merge(
                $select,
                [
                    'spr_tags.name_en as name',
                    'spr_tags.slug_en as slug',
                    'menu_levels.custom_name_en as customName',
                ]
            );
        } else {
            $select = array_merge(
                $select,
                [
                    'spr_tags.name',
                    'spr_tags.seo as slug',
                    'menu_levels.custom_name_ru as customName',
                ]
            );
        }
        $result = $query
            ->select($select)
            ->where(
                function ($query) use ($locale) {
                    if ($locale === 'en') {
                        $query->where('menu_levels.show_en', 1);
                    }
                    if ($locale === 'ru') {
                        $query->where('menu_levels.show_ru', 1);
                    }
                }
            )
            ->leftJoin('spr_tags', 'spr_tags.id', '=', 'menu_levels.spr_tag_id')
            ->orderBy('menu_levels.parent_level_id', 'asc')
            ->getQuery()
            ->get()
            ->toArray();
        $result = array_map(
            function ($item) {
                return (array) $item;
            },
            $result
        );
        return $result;
    }

}
