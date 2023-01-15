<?php

namespace App\Containers\Picture\Data\Criteria\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class JoinPictureTagCriteria extends Criteria
{

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->join(PictureTagsColumnsEnum::TABlE, PictureColumnsEnum::tId, '=', PictureTagsColumnsEnum::tPICTURE_ID);
    }
}
