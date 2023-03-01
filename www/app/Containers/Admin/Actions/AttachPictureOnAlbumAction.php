<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Picture\Actions\Art\GetArtByIdWithFilesAction;
use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsNamesWithoutHiddenVkByPictureIdTask;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\VkWallPostingService;
use App\Containers\Vk\Tasks\VkAlbum\GetVkAlbumByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\CreateVkAlbumPictureTask;
use App\Ship\Parents\Actions\Action;

class AttachPictureOnAlbumAction extends Action
{
    private PhotoService $apiPhotoService;
    private VkWallPostingService $apiPostingService;
    private GetVkAlbumByIdTask $getVkAlbumByIdTask;
    private CreateVkAlbumPictureTask $createVkAlbumPictureTask;
    private GetPictureTagsNamesWithoutHiddenVkByPictureIdTask $getPictureTagsNamesWithoutHiddenVkByPictureIdTask;
    private GetArtByIdWithFilesAction $getArtByIdWithFilesAction;

    public function __construct(
        PhotoService $apiPhotoService,
        VkWallPostingService $apiPostingService,
        GetVkAlbumByIdTask $getVkAlbumByIdTask,
        CreateVkAlbumPictureTask $createVkAlbumPictureTask,
        GetPictureTagsNamesWithoutHiddenVkByPictureIdTask $getPictureTagsNamesWithoutHiddenVkByPictureIdTask,
        GetArtByIdWithFilesAction $getArtByIdWithFilesAction,
    ) {
        $this->apiPhotoService = $apiPhotoService;
        $this->apiPostingService = $apiPostingService;
        $this->getVkAlbumByIdTask = $getVkAlbumByIdTask;
        $this->createVkAlbumPictureTask = $createVkAlbumPictureTask;
        $this->getPictureTagsNamesWithoutHiddenVkByPictureIdTask = $getPictureTagsNamesWithoutHiddenVkByPictureIdTask;
        $this->getArtByIdWithFilesAction = $getArtByIdWithFilesAction;
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
        $art = $this->getArtByIdWithFilesAction->run($artId);
        $artFsPath = $art->images->primary->fs_path;
        $tags = $this->getPictureTagsNamesWithoutHiddenVkByPictureIdTask->run($artId);
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


