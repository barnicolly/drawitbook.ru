<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\RateEnum;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserActivityIsRateCriteria extends Criteria
{

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn(UserActivityColumnsEnum::ACTIVITY, [RateEnum::LIKE]);
    }
}
