<?php

namespace App\UseCases\Vk;

use App\Entities\Vk\VkAlbumModel;

class AttachArtToVkAlbum
{

    protected $_albumId;

    public function __construct(int $albumId, int $artId)
    {
        $this->_albumId = $albumId;
    }

    public function attach()
    {
        $album = VkAlbumModel::find($this->_albumId);
        if (!$album) {
            throw new \Exception('Не найден альбом');
        }

        return VkAlbumModel::find($albumId);
    }

}
