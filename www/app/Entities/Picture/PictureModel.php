<?php

namespace App\Entities\Picture;

use Illuminate\Database\Eloquent\Model;

class PictureModel extends Model
{
    protected $table = 'picture';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    //TODO-misha избавиться;
    public function tags()
    {
        return $this->belongsToMany('App\Entities\Spr\SprTagsModel', 'picture_tags', 'picture_id', 'tag_id');
    }

    public static function getById(int $id): ?array
    {
        $art = self::query()
            ->where('id', $id)
            ->where('is_del', 0)
            ->getQuery()
            ->first();
        if ($art) {
            $art = (array) $art;
            $art['fs_path'] = formArtFsPath($art['path']);
            return $art;
        }
        return null;
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
