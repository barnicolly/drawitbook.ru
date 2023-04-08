<?php

namespace App\Containers\Claim\Data\Criteria;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserClaimUserIdCriteria extends Criteria
{

    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where(UserClaimColumnsEnum::USER_ID, '=', $this->userId);
    }
}
