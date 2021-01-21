<?php

namespace App\Services\Posting;

use App\Entities\Vk\VkAlbumModel;
use App\Entities\Vk\VkAlbumPictureModel;
use App\Services\Api\Vk\PhotoService;
use App\Services\Api\Vk\VkApi;
use App\Services\Arts\GetPicture;

class VkAlbumService
{

    private $apiInstance;
    private $photoService;
    private $postingService;

    public function __construct()
    {
        $apiInstance = (new VkApi());
        $this->apiInstance = $apiInstance;
        $this->photoService = (new PhotoService($apiInstance));
        $this->postingService = (new PostingService());
    }

    public function get()
    {
        return VkAlbumModel::get();
    }

    public function attachArtOnAlbum(int $artId, int $albumId)
    {
        $album = VkAlbumModel::find($albumId);
        if (!$album) {
            throw new \Exception('Не найден альбом');
        }
        $getPicture = new GetPicture($artId);
        $picture = $getPicture->withHiddenVkTag()->get();

        $path = formArtFsPath($picture->path);

        $tags = $picture->tags->pluck('name')->toArray();
        $photoId = $this->postPhotoInAlbum($album, $path, $tags);

        //TODO-misha вынести;
        $vkAlbumPictureModel = new VkAlbumPictureModel();
        $vkAlbumPictureModel->vk_album_id = $album->id;
        $vkAlbumPictureModel->out_vk_image_id = $photoId;
        $vkAlbumPictureModel->picture_id = $picture->id;
        $album->pictures()->save($vkAlbumPictureModel);
    }

    public function detachArtFromAlbum(int $artId, int $albumId)
    {
        $album = VkAlbumModel::find($albumId);
        if (!$album) {
            throw new \Exception('Не найден альбом');
        }
        //TODO-misha вынести связь с моделью;
        $vkAlbumPicture = VkAlbumPictureModel::where('vk_album_id', '=', $album->id)
            ->where('picture_id', '=', $artId)
            ->first();
        if (!$vkAlbumPicture) {
            throw new \Exception('Не найдена запись связи изображения и альбома ВК');
        }
        //TODO-misha вынести;
        $photoId = $vkAlbumPicture->out_vk_image_id;
        $this->photoService->delete($photoId);
        $vkAlbumPicture->delete();
    }

    private function postPhotoInAlbum($album, string $path, array $tags): ?int
    {
        $photoId = $this->photoService->saveOnAlbum($path, $album->album_id);
        if ($album->share) {
            $url = $album->share;
        } else {
            $url = 'https://drawitbook.ru';
        }
        $hashTags = $this->postingService->formHashTags($tags);
        sleep(1);
        $this->photoService->edit($photoId, ['caption' => $hashTags . "\n\n" . ' Больше рисунков ► ' . $url]);
        return $photoId;
    }

}

