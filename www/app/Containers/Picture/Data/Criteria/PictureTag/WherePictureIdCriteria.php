<?php

namespace App\Containers\Picture\Data\Criteria\PictureTag;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureIdCriteria extends Criteria
{
    private int $pictureId;

    public function __construct(int $pictureId)
    {
        $this->pictureId = $pictureId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(PictureTagsColumnsEnum::$tPICTURE_ID, '=', $this->pictureId);
    }
}
