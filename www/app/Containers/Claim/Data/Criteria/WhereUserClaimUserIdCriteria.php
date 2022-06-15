<?php

namespace App\Containers\Claim\Data\Criteria;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserClaimUserIdCriteria extends Criteria
{

    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(UserClaimColumnsEnum::USER_ID, '=', $this->userId);
    }
}
