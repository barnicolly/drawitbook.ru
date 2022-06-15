<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserActivityUserIdCriteria extends Criteria
{

    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(UserActivityColumnsEnum::USER_ID, '=', $this->userId);
    }
}
