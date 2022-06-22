<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Picture\Services\ArtsService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\VkWallPostingService;
use App\Containers\Vk\Tasks\VkAlbum\GetVkAlbumByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\CreateVkAlbumPictureTask;
use App\Ship\Parents\Actions\Action;

class AttachPictureOnAlbumAction extends Action
{
    private PhotoService $apiPhotoService;
    private VkWallPostingService $apiPostingService;
    private ArtsService $artsService;
    private TagsService $tagsService;
    private GetVkAlbumByIdTask $getVkAlbumByIdTask;
    private CreateVkAlbumPictureTask $createVkAlbumPictureTask;

    /**
     * @param PhotoService $apiPhotoService
     * @param VkWallPostingService $apiPostingService
     * @param ArtsService $artsService
     * @param TagsService $tagsService
     * @param GetVkAlbumByIdTask $getVkAlbumByIdTask
     * @param CreateVkAlbumPictureTask $createVkAlbumPictureTask
     */
    public function __construct(
        PhotoService $apiPhotoService,
        VkWallPostingService $apiPostingService,
        ArtsService $artsService,
        TagsService $tagsService,
        GetVkAlbumByIdTask $getVkAlbumByIdTask,
        CreateVkAlbumPictureTask $createVkAlbumPictureTask
    ) {
        $this->apiPhotoService = $apiPhotoService;
        $this->apiPostingService = $apiPostingService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->getVkAlbumByIdTask = $getVkAlbumByIdTask;
        $this->createVkAlbumPictureTask = $createVkAlbumPictureTask;
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
        $art = $this->artsService->getById($artId);
        $artFsPath = $art['images']['primary']['fs_path'];
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($artId);
        $photoId = $this->postPhotoInAlbum($vkAlbum->album_id, $vkAlbum->share, $artFsPath, $tags);
        $this->createVkAlbumPictureTask->run($artId, $vkAlbum->id, $photoId);
    }

    private function postPhotoInAlbum(int $albumId, ?string $albumShareLink, string $path, array $tags): ?int
    {
        $photoId = $this->apiPhotoService->saveOnAlbum($path, $albumId);
        if ($albumShareLink) {
            $url = $albumShareLink;
        } else {
            $url = 'https://drawitbook.com/ru';
        }
        $hashTags = $this->apiPostingService->formHashTags($tags);
        $this->apiPhotoService->timeout();
        $this->apiPhotoService->edit($photoId, ['caption' => $hashTags . "\n\n" . ' Больше рисунков ► ' . $url], true);
        return $photoId;
    }

}


