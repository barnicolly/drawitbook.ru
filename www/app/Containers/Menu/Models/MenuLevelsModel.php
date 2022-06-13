<?php

namespace App\Containers\Menu\Models;

use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $spr_tag_id
 * @property int $parent_level_id
 * @property string $custom_name_ru
 * @property string $custom_name_en
 * @property int $show_ru
 * @property int $show_en
 * @property int $column
 */
class MenuLevelsModel extends CoreModel
{
    protected $table = MenuLevelsColumnsEnum::TABlE;

    protected $fillable = [];

    public static function getAll(string $locale): array
    {
        $query = self::query();
        $select = [
            MenuLevelsColumnsEnum::$tId,
            MenuLevelsColumnsEnum::$tPARENT_LEVEL_ID,
            MenuLevelsColumnsEnum::$tCOLUMN,
        ];
        if ($locale === LangEnum::EN) {
            $select = array_merge(
                $select,
                [
                    SprTagsColumnsEnum::$tNAME_EN . ' as name',
                    SprTagsColumnsEnum::$tSLUG_EN . ' as seo',
                    MenuLevelsColumnsEnum::$tCUSTOM_NAME_EN . ' as customName',
                ]
            );
        } else {
            $select = array_merge(
                $select,
                [
                    SprTagsColumnsEnum::$tNAME,
                    SprTagsColumnsEnum::$tSEO,
                    MenuLevelsColumnsEnum::$tCUSTOM_NAME_RU . ' as customName',
                ]
            );
        }
        $result = $query
            ->select($select)
            ->where(
                function ($query) use ($locale) {
                    if ($locale === LangEnum::EN) {
                        $query->where(MenuLevelsColumnsEnum::$tSHOW_EN, 1);
                    }
                    if ($locale === LangEnum::RU) {
                        $query->where(MenuLevelsColumnsEnum::$tSHOW_RU, 1);
                    }
                }
            )
            ->leftJoin(SprTagsColumnsEnum::TABlE, SprTagsColumnsEnum::$tId, '=', MenuLevelsColumnsEnum::$tSPR_TAG_ID)
            ->orderBy(MenuLevelsColumnsEnum::$tPARENT_LEVEL_ID, 'asc')
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

}
