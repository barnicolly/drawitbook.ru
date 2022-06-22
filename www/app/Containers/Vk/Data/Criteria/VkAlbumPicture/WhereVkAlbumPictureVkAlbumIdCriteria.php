<?php

namespace App\Containers\Vk\Data\Criteria\VkAlbumPicture;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereVkAlbumPictureVkAlbumIdCriteria extends Criteria
{
    private int $vkAlbumId;

    public function __construct(int $vkAlbumId)
    {
        $this->vkAlbumId = $vkAlbumId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, '=', $this->vkAlbumId);
    }
}
