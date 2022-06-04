<?php

namespace App\Containers\Tag\Data\Criteria;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereTagNotHiddenCriteria extends Criteria
{

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(SprTagsColumnsEnum::$tHIDDEN, '=', 0);
    }
}
