<?php

namespace App\Containers\Picture\Data\Criteria;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Enums\SoftDeleteStatusEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureNotDeletedCriteria extends Criteria
{

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(PictureColumnsEnum::IS_DEL, SoftDeleteStatusEnum::FALSE);
    }
}
