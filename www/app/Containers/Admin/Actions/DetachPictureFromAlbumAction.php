<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Vk\Services\AlbumService;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Ship\Parents\Actions\Action;

class DetachPictureFromAlbumAction extends Action
{
    private PhotoService $apiPhotoService;
    private AlbumService $albumService;

    /**
     * @param AlbumService $albumService
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(AlbumService $albumService)
    {
//        todo-misha реализовать через контейнер;
        $apiInstance = app(VkApi::class);
        $this->apiPhotoService = app()->make(PhotoService::class, ['api' => $apiInstance]);
        $this->albumService = $albumService;
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
//        todo-misha вынести в таск проверки;
        $vkAlbum = $this->albumService->getById($vkAlbumId);
        if (!$vkAlbum) {
            throw new \Exception('Не найден альбом');
        }
        //        todo-misha вынести в таск проверки;
        $vkAlbumPicture = $this->albumService->getRowByVkAlbumIdAndPictureId($vkAlbum['id'], $artId);
        if (!$vkAlbumPicture) {
            throw new \Exception('Не найдена запись связи изображения и альбома ВК');
        }
        $photoId = $vkAlbumPicture['out_vk_image_id'];
        $this->apiPhotoService->delete($photoId);
        $this->albumService->deleteVkAlbumPictureById($vkAlbumPicture['id']);
    }

}


