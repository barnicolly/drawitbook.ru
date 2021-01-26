<?php

namespace App\Entities\Picture;

use Illuminate\Database\Eloquent\Model;

class PictureTagsModel extends Model
{
    protected $table = 'picture_tags';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getNamesWithoutHiddenVkByArtId(int $artId): array
    {
        $query = self::query();
        return $query->where('picture_id', $artId)
            ->where('spr_tags.hidden_vk', 0)
            ->join('spr_tags', 'spr_tags.id', '=', 'picture_tags.tag_id')
            ->getQuery()
            ->get()
            ->pluck('name')
            ->toArray();
    }

}
