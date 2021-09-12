<?php

namespace App\Entities\Vk;

use App\Models\CoreModel;

class VkAlbumModel extends CoreModel
{
    protected $table = 'vk_album';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
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
        return self::mapToArray($result);
    }

}
