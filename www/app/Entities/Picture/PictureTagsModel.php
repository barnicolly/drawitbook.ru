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

    public static function getTagsByArtIds(array $artIds, bool $withHidden): array
    {
        $query = self::query();
        $result = $query->whereIn('picture_id', $artIds)
            ->join('spr_tags', 'spr_tags.id', '=', 'picture_tags.tag_id')
            ->where(
                function ($query) use ($withHidden) {
                    if (!$withHidden) {
                        $query->where('spr_tags.hidden', '=', 0);
                    }
                }
            )
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
