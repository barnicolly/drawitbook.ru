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

}
