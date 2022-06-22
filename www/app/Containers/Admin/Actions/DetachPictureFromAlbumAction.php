<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Containers\Vk\Tasks\VkAlbum\GetVkAlbumByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\DeleteVkAlbumPictureByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\GetVkAlbumPictureByVkAlbumIdAndPictureIdTask;
use App\Ship\Parents\Actions\Action;

class DetachPictureFromAlbumAction extends Action
{
    private PhotoService $apiPhotoService;
    private GetVkAlbumByIdTask $getVkAlbumByIdTask;
    private GetVkAlbumPictureByVkAlbumIdAndPictureIdTask $getVkAlbumPictureByVkAlbumIdAndPictureIdTask;
    private DeleteVkAlbumPictureByIdTask $deleteVkAlbumPictureByIdTask;

    /**
     * @param GetVkAlbumByIdTask $getVkAlbumByIdTask
     * @param GetVkAlbumPictureByVkAlbumIdAndPictureIdTask $getVkAlbumPictureByVkAlbumIdAndPictureIdTask
     * @param DeleteVkAlbumPictureByIdTask $deleteVkAlbumPictureByIdTask
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(
        GetVkAlbumByIdTask $getVkAlbumByIdTask,
        GetVkAlbumPictureByVkAlbumIdAndPictureIdTask $getVkAlbumPictureByVkAlbumIdAndPictureIdTask,
        DeleteVkAlbumPictureByIdTask $deleteVkAlbumPictureByIdTask
    ) {
        //        todo-misha реализовать через контейнер;
        $apiInstance = app(VkApi::class);
        $this->apiPhotoService = app()->make(PhotoService::class, ['api' => $apiInstance]);
        $this->getVkAlbumByIdTask = $getVkAlbumByIdTask;
        $this->getVkAlbumPictureByVkAlbumIdAndPictureIdTask = $getVkAlbumPictureByVkAlbumIdAndPictureIdTask;
        $this->deleteVkAlbumPictureByIdTask = $deleteVkAlbumPictureByIdTask;
    }

    /**
     * @param int $artId
     * @param int $vkAlbumId
     * @return void
     *
     * @throws \Exception
     */
    public function run(int $artId, int $vkAlbumId): void
    {
        $vkAlbum = $this->getVkAlbumByIdTask->run($vkAlbumId);
        $vkAlbumPicture = $this->getVkAlbumPictureByVkAlbumIdAndPictureIdTask->run($vkAlbum->id, $artId);
        $this->apiPhotoService->delete($vkAlbumPicture->out_vk_image_id);
        $this->deleteVkAlbumPictureByIdTask->run($vkAlbumPicture->id);
    }

}


