<?php

declare(strict_types=1);

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Ship\Parents\Tasks\Task;

class CreateVkAlbumPictureTask extends Task
{
    public function __construct(protected VkAlbumPictureRepository $repository)
    {
    }

    public function run(int $artId, int $vkAlbumId, int $outVkAlbumId): VkAlbumPictureModel
    {
        $model = new VkAlbumPictureModel();
        $model->vk_album_id = $vkAlbumId;
        $model->out_vk_image_id = $outVkAlbumId;
        $model->picture_id = $artId;
        $model->save();
        return $model;
    }
}
