<?php

namespace App\Services\Posting;

use App\Services\Album\AlbumService;
use App\Services\Api\Vk\PhotoService;
use App\Services\Api\Vk\VkApi;
use App\Services\Arts\ArtsService;
use App\Services\Tags\TagsService;

class VkAlbumService
{

    private $apiInstance;
    private $apiPhotoService;
    private $apiPostingService;
    private $artsService;
    private $tagsService;
    private $albumService;

    public function __construct()
    {
        $apiInstance = (new VkApi());
        $this->apiInstance = $apiInstance;
        $this->apiPhotoService = (new PhotoService($apiInstance));
        $this->apiPostingService = (new PostingService());
        $this->artsService = (new ArtsService());
        $this->tagsService = (new TagsService());
        $this->albumService = (new AlbumService());
    }

    public function attachArtOnAlbum(int $artId, int $vkAlbumId)
    {
        $vkAlbum = $this->albumService->getById($vkAlbumId);
        if (!$vkAlbum) {
            throw new \Exception('Не найден альбом');
        }
        $art = $this->artsService->getById($artId);
        if (!$art) {
            throw new \Exception('Не найдено изображения');
        }
        $artFsPath = $art['images']['primary']['fs_path'];
        $tags = $this->tagsService->getNamesWithoutHiddenVkByArtId($artId);
        $photoId = $this->postPhotoInAlbum($vkAlbum['album_id'], $vkAlbum['share'], $artFsPath, $tags);
        $this->artsService->attachArtToVkAlbum($artId, $vkAlbum['id'], $photoId);
    }

    public function detachArtFromAlbum(int $artId, int $vkAlbumId)
    {
        $vkAlbum = $this->albumService->getById($vkAlbumId);
        if (!$vkAlbum) {
            throw new \Exception('Не найден альбом');
        }
        $vkAlbumPicture = $this->albumService->getRowByVkAlbumIdAndPictureId($vkAlbum['id'], $artId);
        if (!$vkAlbumPicture) {
            throw new \Exception('Не найдена запись связи изображения и альбома ВК');
        }
        $photoId = $vkAlbumPicture['out_vk_image_id'];
        $this->apiPhotoService->delete($photoId);
        $this->albumService->deleteVkAlbumPictureById($vkAlbumPicture['id']);
    }

    private function postPhotoInAlbum(int $albumId, string $albumShareLink, string $path, array $tags): ?int
    {
        $photoId = $this->apiPhotoService->saveOnAlbum($path, $albumId);
        if ($albumShareLink) {
            $url = $albumShareLink;
        } else {
            $url = 'https://drawitbook.com/ru';
        }
        $hashTags = $this->apiPostingService->formHashTags($tags);
        sleep(1);
        $this->apiPhotoService->edit($photoId, ['caption' => $hashTags . "\n\n" . ' Больше рисунков ► ' . $url]);
        return $photoId;
    }

}

