<?php

namespace App\Services\Api\Vk;

use App\Entities\Vk\VkAlbumModel;
use App\Entities\Vk\VkAlbumPictureModel;
use App\Services\Arts\GetPicture;
use App\Services\Api\Vk\Core\VkApi;

class DetachArtFromVkAlbum extends VkApi
{

    protected $_albumId;
    protected $_artId;

    public function __construct(int $albumId, int $artId)
    {
        parent::__construct();
        $this->_albumId = $albumId;
        $this->_artId = $artId;
    }

    public function detach()
    {
        $album = VkAlbumModel::find($this->_albumId);
        if (!$album) {
            throw new \Exception('Не найден альбом');
        }
        $getPicture = new GetPicture($this->_artId);
        $picture = $getPicture->get();
        $vkAlbumPicture = VkAlbumPictureModel::where('vk_album_id', '=', $album->id)
            ->where('picture_id', '=', $this->_artId)
            ->first();
        if (!$vkAlbumPicture) {
            throw new \Exception('Не найдена запись связи изображения и альбома ВК');
        }
        $photoId = $vkAlbumPicture->out_vk_image_id;
        $this->_deletePhoto($photoId);
        $vkAlbumPicture->delete();
    }

}
