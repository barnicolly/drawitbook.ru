<?php

namespace App\Containers\Picture\Data\Criteria\PictureTag;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureIdsCriteria extends Criteria
{
    private array $pictureIds;

    public function __construct(array $pictureIds)
    {
        $this->pictureIds = $pictureIds;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn(PictureTagsColumnsEnum::$tPICTURE_ID, $this->pictureIds);
    }
}
