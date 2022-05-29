<?php

namespace App\Containers\Vk\Models;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $vk_album_id
 * @property int $picture_id
 * @property int $out_vk_image_id
 */
class VkAlbumPictureModel extends CoreModel
{
    protected $table = VkAlbumPictureColumnsEnum::TABlE;

    protected $fillable = [];
    public $timestamps = false;

    public static function getRowByVkAlbumIdAndPictureId(int $vkAlbumId, int $artId): ?array
    {
        $result = self::query()
            ->where(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, '=', $vkAlbumId)
            ->where(VkAlbumPictureColumnsEnum::PICTURE_ID, '=', $artId)
            ->getQuery()
            ->first();
        return $result
            ? $result->toArray()
            : null;
    }

    public static function getAlbumVkPictures(int $artId, array $vkAlbumIds): array
    {
        $result = self::query()
            ->whereIn(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, $vkAlbumIds)
            ->where(VkAlbumPictureColumnsEnum::PICTURE_ID, $artId)
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
