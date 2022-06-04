<?php

namespace App\Containers\Picture\Data\Criteria\PictureExtension;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Enums\SoftDeleteStatusEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureExtensionNotDeletedCriteria extends Criteria
{

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(PictureExtensionsColumnsEnum::$tIS_DEL, SoftDeleteStatusEnum::FALSE);
    }
}
