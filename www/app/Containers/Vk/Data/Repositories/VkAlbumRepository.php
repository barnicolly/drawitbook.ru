<?php

declare(strict_types=1);

namespace App\Containers\Vk\Data\Repositories;

use App\Containers\Vk\Models\VkAlbumModel;
use App\Ship\Parents\Repositories\Repository;

final class VkAlbumRepository extends Repository
{
    public function model(): string
    {
        return VkAlbumModel::class;
    }
}
