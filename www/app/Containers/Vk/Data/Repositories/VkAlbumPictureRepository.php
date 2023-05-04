<?php

namespace App\Containers\Vk\Data\Repositories;

use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Ship\Parents\Repositories\Repository;

class VkAlbumPictureRepository extends Repository
{
    public function model(): string
    {
        return VkAlbumPictureModel::class;
    }
}
