<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $picture_id
 * @property string $path
 * @property int $width
 * @property int $height
 * @property string $ext
 * @property int $is_del
 */
class PictureExtensionsModel extends CoreModel
{
    protected $table = PictureExtensionsColumnsEnum::TABlE;

    protected $fillable = [];

    public static function getByPictureIds(array $pictureIds): array
    {
        $result = self::query()
            ->whereIn(PictureExtensionsColumnsEnum::PICTURE_ID, $pictureIds)
            ->where(PictureExtensionsColumnsEnum::IS_DEL, 0)
            ->getQuery()
            ->get()
            ->toArray();
        $result = self::mapToArray($result);
        return groupArray($result, PictureExtensionsColumnsEnum::PICTURE_ID);
    }

}
