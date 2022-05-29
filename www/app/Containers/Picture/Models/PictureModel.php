<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property string $description
 * @property int $is_del
 * @property int $in_common
 * @property int $in_vk_posting
 */
class PictureModel extends CoreModel
{
    protected $table = PictureColumnsEnum::TABlE;

    protected $fillable = [];

    public static function getInterestingArts(int $excludeId, int $limit): array
    {
        $result = self::query()
            ->take($limit)
            ->where(PictureColumnsEnum::IS_DEL, 0)
            ->where(PictureColumnsEnum::ID, '!=', $excludeId)
            ->where(PictureColumnsEnum::IN_COMMON, IN_MAIN_PAGE)
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

    public static function getById(int $id): ?array
    {
        $art = self::query()
            ->where(PictureColumnsEnum::ID, $id)
            ->where(PictureColumnsEnum::IS_DEL, 0)
            ->getQuery()
            ->first();
        if ($art) {
            return (array) $art;
        }
        return null;
    }

    public static function getByIds(array $ids): array
    {
        $result = self::query()
            ->whereIn(PictureColumnsEnum::ID, $ids)
            ->where(PictureColumnsEnum::IS_DEL, 0)
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

    public static function updateVkPosting(int $artId, int $status): bool
    {
        $art = self::find($artId);
        if ($art) {
            return false;
        }
        $art->in_vk_posting = $status;
        $art->save();
        return true;
    }

}
