<?php

namespace App\Services\Album;


use App\Entities\Vk\VkAlbumModel;
use App\Entities\Vk\VkAlbumPictureModel;

class AlbumService
{
    public function getAlbumVkPictures(int $artId, array $vkAlbumIds): array
    {
        return VkAlbumPictureModel::getAlbumVkPictures($artId, $vkAlbumIds);
    }

    public function getRowByVkAlbumIdAndPictureId(int $vkAlbumId, int $artId): ?array
    {
        return VkAlbumPictureModel::getRowByVkAlbumIdAndPictureId($vkAlbumId, $artId);
    }

    public function deleteVkAlbumPictureById(int $vkAlbumPictureId): int
    {
        return VkAlbumPictureModel::destroy($vkAlbumPictureId);
    }

    public function getVkAlbums(): array
    {
        return VkAlbumModel::getAll();
    }

    public function extractVkAlbumIds(array $vkAlbumPictures): array
    {
        $vkAlbumIds = [];
        if ($vkAlbumPictures) {
            foreach ($vkAlbumPictures as $vkAlbumPicture) {
                $vkAlbumId = $vkAlbumPicture['vk_album_id'];
                if (!in_array($vkAlbumId, $vkAlbumIds, true)) {
                    $vkAlbumIds[] = $vkAlbumId;
                }
            }
        }
        return $vkAlbumIds;
    }

    public function getById(int $vkAlbumId): ?array
    {
        return VkAlbumModel::getById($vkAlbumId);
    }

}

