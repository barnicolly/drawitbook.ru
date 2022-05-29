<?php

namespace App\Containers\Vk\Models;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Models\CoreModel;

/**
 * @property int $id
 * @property int $album_id
 * @property string $description
 * @property string $share
 */
class VkAlbumModel extends CoreModel
{
    protected $table = VkAlbumPictureColumnsEnum::TABlE;

    protected $fillable = [];

    public static function getById(int $vkAlbumId): ?array
    {
        $album = self::query()
            ->find($vkAlbumId);
        return $album
            ? $album->toArray()
            : null;
    }

    public static function getAll(): array
    {
        $result = self::query()
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

}
