<?php

namespace App\Containers\Admin\Actions;

use Exception;
use App\Containers\Picture\Actions\Art\GetArtByIdWithFilesAction;
use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsNamesWithoutHiddenVkByPictureIdTask;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Tasks\FormHashTagsTask;
use App\Containers\Vk\Tasks\VkAlbum\GetVkAlbumByIdTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\CreateVkAlbumPictureTask;
use App\Ship\Parents\Actions\Action;

class AttachPictureOnAlbumAction extends Action
{
    public function __construct(private readonly PhotoService $apiPhotoService, private readonly GetVkAlbumByIdTask $getVkAlbumByIdTask, private readonly CreateVkAlbumPictureTask $createVkAlbumPictureTask, private readonly GetPictureTagsNamesWithoutHiddenVkByPictureIdTask $getPictureTagsNamesWithoutHiddenVkByPictureIdTask, private readonly GetArtByIdWithFilesAction $getArtByIdWithFilesAction, private readonly FormHashTagsTask $formHashTagsTask)
    {
    }

    /**
     *
     * @throws Exception
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
        $url = $albumShareLink ?: 'https://drawitbook.com/ru';
        $hashTags = $this->formHashTagsTask->run($tags);
        $this->apiPhotoService->timeout();
        $this->apiPhotoService->edit($photoId, ['caption' => $hashTags . "\n\n" . ' Больше рисунков ► ' . $url]);
        return $photoId;
    }

}


