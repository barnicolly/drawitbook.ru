<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserActivityPictureIdCriteria extends Criteria
{

    private int $pictureId;

    public function __construct(int $pictureId)
    {
        $this->pictureId = $pictureId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(UserActivityColumnsEnum::PICTURE_ID, '=', $this->pictureId);
    }
}
