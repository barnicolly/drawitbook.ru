<?php

namespace App\Entities\Vk;

use Illuminate\Database\Eloquent\Model;

class VkAlbumModel extends Model
{
    protected $table = 'vk_album';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function pictures()
    {
        return $this->hasMany('App\Entities\Vk\VkAlbumPictureModel', 'vk_album_id', 'id');
    }

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
        $result = array_map(
            function ($item) {
                return (array) $item;
            },
            $result
        );
        return $result;
    }

}
