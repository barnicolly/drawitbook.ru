<?php

namespace App\Containers\Vk\Data\Criteria\VkAlbumPicture;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereVkAlbumPictureVkAlbumIdsCriteria extends Criteria
{
    private array $vkAlbumIds;

    public function __construct(array $vkAlbumIds)
    {
        $this->vkAlbumIds = $vkAlbumIds;
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereIn(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, $this->vkAlbumIds);
    }
}
