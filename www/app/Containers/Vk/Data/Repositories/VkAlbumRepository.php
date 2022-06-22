<?php

namespace App\Containers\Vk\Data\Repositories;

use App\Containers\Vk\Models\VkAlbumModel;
use App\Ship\Parents\Repositories\Repository;

class VkAlbumRepository extends Repository
{

    public function model(): string
    {
        return VkAlbumModel::class;
    }
}
