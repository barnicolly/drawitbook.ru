<?php

namespace App\Containers\Vk\Data\Criteria\VkAlbumPicture;

use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereVkAlbumPicturePictureIdCriteria extends Criteria
{
    private int $pictureId;

    public function __construct(int $pictureId)
    {
        $this->pictureId = $pictureId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(VkAlbumPictureColumnsEnum::PICTURE_ID, '=', $this->pictureId);
    }
}
