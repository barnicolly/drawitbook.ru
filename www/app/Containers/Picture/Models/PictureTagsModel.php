<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Models\SprTagsModel;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Support\Facades\DB;

class PictureTagsModel extends CoreModel
{
    protected $table = PictureTagsColumnsEnum::TABlE;

    protected $fillable = [];

//    todo-misha разгрузить ответственность;

    public static function getTagsByArtIds(array $artIds, bool $withHidden, string $locale): array
    {
        $query = self::query();
        if ($locale === LangEnum::EN) {
            $select = [
                PictureTagsColumnsEnum::$tId,
                PictureTagsColumnsEnum::$tPICTURE_ID,
                PictureTagsColumnsEnum::$tTAG_ID,
                SprTagsColumnsEnum::$tHIDDEN,
                SprTagsColumnsEnum::$tHIDDEN_VK,
                SprTagsColumnsEnum::$tNAME_EN . ' as name',
                SprTagsColumnsEnum::$tSLUG_EN . ' as seo',
            ];
        } else {
            $select = [
                PictureTagsColumnsEnum::$tId,
                PictureTagsColumnsEnum::$tPICTURE_ID,
                PictureTagsColumnsEnum::$tTAG_ID,
                SprTagsColumnsEnum::$tHIDDEN,
                SprTagsColumnsEnum::$tHIDDEN_VK,
                SprTagsColumnsEnum::$tNAME,
                SprTagsColumnsEnum::$tSEO,
            ];
        }
        $result = $query->whereIn(PictureTagsColumnsEnum::PICTURE_ID, $artIds)
            ->select($select)
            ->join(SprTagsColumnsEnum::TABlE, SprTagsColumnsEnum::$tId, '=', PictureTagsColumnsEnum::$tTAG_ID)
            ->where(
                function ($query) use ($withHidden) {
                    if (!$withHidden) {
                        $query->where(SprTagsColumnsEnum::$tHIDDEN, '=', 0);
                    }
                }
            )
            ->where(
                function ($query) use ($locale) {
                    if ($locale === LangEnum::EN) {
                        $query->whereNotNull(SprTagsColumnsEnum::$tSLUG_EN);
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
        if ($locale === LangEnum::EN) {
            $select = [
                SprTagsColumnsEnum::$tNAME_EN . ' as name',
                SprTagsColumnsEnum::$tSLUG_EN . ' as seo',
                DB::raw('count("' . PictureTagsColumnsEnum::$tId . '") as count'),
            ];
        } else {
            $select = [
                SprTagsColumnsEnum::$tNAME,
                SprTagsColumnsEnum::$tSEO,
                DB::raw('count("' . PictureTagsColumnsEnum::$tId . '") as count'),
            ];
        }
        $result = $query
            ->select($select)
            ->where(
                function ($query) use ($locale) {
                    if ($locale === LangEnum::EN) {
                        $query->whereNotNull(SprTagsColumnsEnum::$tSLUG_EN);
                    }
                }
            )
            ->where(SprTagsColumnsEnum::$tHIDDEN, 0)
            ->join(PictureTagsColumnsEnum::TABlE, PictureTagsColumnsEnum::$tTAG_ID, '=', SprTagsColumnsEnum::$tId)
            ->groupBy(SprTagsColumnsEnum::$tId)
            ->orderBy('count', 'desc')
            ->take($limit)
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

}
