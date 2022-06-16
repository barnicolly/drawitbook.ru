<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\LikesColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereLikesPictureIdCriteria extends Criteria
{

    private int $pictureId;

    public function __construct(int $pictureId)
    {
        $this->pictureId = $pictureId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(LikesColumnsEnum::PICTURE_ID, '=', $this->pictureId);
    }
}
