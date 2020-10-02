<?php

namespace App\UseCases\Vk;

use App\Entities\Vk\VkAlbumModel;

class GetVkAlbums
{


    public function __construct()
    {
    }

    public function get()
    {
        return VkAlbumModel::get();
    }

}
