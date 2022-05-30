<?php

namespace App\Containers\Picture\Data\Criteria\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Enums\ShowOnMainPageStatusEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureShowInMainPageCriteria extends Criteria
{

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(PictureColumnsEnum::IN_COMMON, ShowOnMainPageStatusEnum::ON);
    }
}
