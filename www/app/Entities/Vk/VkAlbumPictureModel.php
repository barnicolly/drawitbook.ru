<?php

namespace App\Entities\Vk;

use Illuminate\Database\Eloquent\Model;

class VkAlbumPictureModel extends Model
{
    protected $table = 'vk_album_picture';

    protected $fillable = [];
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

}
