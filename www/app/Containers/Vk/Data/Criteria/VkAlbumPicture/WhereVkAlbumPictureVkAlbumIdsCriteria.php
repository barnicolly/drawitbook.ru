<?php

namespace App\Containers\Vk\Data\Criteria\VkAlbumPicture;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereVkAlbumPictureVkAlbumIdsCriteria extends Criteria
{
    private array $vkAlbumIds;

    public function __construct(array $vkAlbumIds)
    {
        $this->vkAlbumIds = $vkAlbumIds;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, $this->vkAlbumIds);
    }
}
