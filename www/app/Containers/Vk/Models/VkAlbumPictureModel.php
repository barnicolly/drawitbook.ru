<?php

namespace App\Containers\Vk\Models;

use App\Models\CoreModel;

class VkAlbumPictureModel extends CoreModel
{
    protected $table = 'vk_album_picture';

    protected $fillable = [];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getRowByVkAlbumIdAndPictureId(int $vkAlbumId, int $artId): ?array
    {
        $result = self::query()
            ->where('vk_album_id', '=', $vkAlbumId)
            ->where('picture_id', '=', $artId)
            ->getQuery()
            ->first();
        return $result
            ? $result->toArray()
            : null;
    }

    public static function getAlbumVkPictures(int $artId, array $vkAlbumIds): array
    {
        $result = self::query()
            ->whereIn('vk_album_id', $vkAlbumIds)
            ->where('picture_id', $artId)
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
