<?php

namespace App\Http\Modules\Database\Models\Common\Picture;

use Illuminate\Database\Eloquent\Model;

class PictureModel extends Model
{
    protected $table = 'picture';

    protected $fillable = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function tags()
    {
        return $this->belongsToMany('App\Http\Modules\Database\Models\Common\Spr\SprTagsModel', 'picture_tags', 'picture_id', 'tag_id');
    }
}
