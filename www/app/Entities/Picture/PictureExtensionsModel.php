<?php

namespace App\Entities\Picture;

use App\Models\CoreModel;

class PictureExtensionsModel extends CoreModel
{
    protected $table = 'picture_extensions';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getByPictureIds(array $pictureIds): array
    {
        $result = self::query()
            ->whereIn('picture_id', $pictureIds)
            ->where('is_del', 0)
            ->getQuery()
            ->get()
            ->toArray();
        $result = self::mapToArray($result);
        return groupArray($result, 'picture_id');
    }

}
