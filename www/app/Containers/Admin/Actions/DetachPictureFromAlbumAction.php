<?php

namespace App\Containers\Admin\Actions;

use Exception;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Tasks\VkAlbum\GetVkAlbumByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\DeleteVkAlbumPictureByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\GetVkAlbumPictureByVkAlbumIdAndPictureIdTask;
use App\Ship\Parents\Actions\Action;

class DetachPictureFromAlbumAction extends Action
{
    public function __construct(private readonly PhotoService $apiPhotoService, private readonly GetVkAlbumByIdTask $getVkAlbumByIdTask, private readonly GetVkAlbumPictureByVkAlbumIdAndPictureIdTask $getVkAlbumPictureByVkAlbumIdAndPictureIdTask, private readonly DeleteVkAlbumPictureByIdTask $deleteVkAlbumPictureByIdTask)
    {
    }

    /**
     * @throws Exception
     */
    public function run(int $artId, int $vkAlbumId): void
    {
        $vkAlbum = $this->getVkAlbumByIdTask->run($vkAlbumId);
        $vkAlbumPicture = $this->getVkAlbumPictureByVkAlbumIdAndPictureIdTask->run($vkAlbum->id, $artId);
        $this->apiPhotoService->delete($vkAlbumPicture->out_vk_image_id);
        $this->deleteVkAlbumPictureByIdTask->run($vkAlbumPicture->id);
    }
}
