<?php

namespace App\Containers\Vk\Tasks\VkAlbumPicture;

use App\Containers\Vk\Data\Repositories\VkAlbumPictureRepository;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Ship\Parents\Tasks\Task;

class CreateVkAlbumPictureTask extends Task
{

    protected VkAlbumPictureRepository $repository;

    public function __construct(VkAlbumPictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $artId
     * @param int $vkAlbumId
     * @param int $outVkAlbumId
     * @return VkAlbumPictureModel
     */
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


