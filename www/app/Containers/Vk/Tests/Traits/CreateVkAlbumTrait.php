<?php

namespace App\Containers\Vk\Tests\Traits;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Containers\Vk\Models\VkAlbumModel;
use App\Containers\Vk\Models\VkAlbumPictureModel;

trait CreateVkAlbumTrait
{

    public function createVkAlbum(): VkAlbumModel
    {
        return VkAlbumModel::factory()->create();
    }

    public function createVkAlbumPicture(VkAlbumModel $vkAlbum): VkAlbumPictureModel
    {
        return VkAlbumPictureModel::factory()->create(
            [
                VkAlbumPictureColumnsEnum::VK_ALBUM_ID => $vkAlbum->id,
            ]
        );
    }
}
