<?php

namespace App\Containers\Vk\Data\Criteria\VkAlbumPicture;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereVkAlbumPictureVkAlbumIdCriteria extends Criteria
{
    private int $vkAlbumId;

    public function __construct(int $vkAlbumId)
    {
        $this->vkAlbumId = $vkAlbumId;
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where(VkAlbumPictureColumnsEnum::VK_ALBUM_ID, '=', $this->vkAlbumId);
    }
}
