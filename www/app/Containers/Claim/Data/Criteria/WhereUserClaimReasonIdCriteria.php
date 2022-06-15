<?php

namespace App\Containers\Claim\Data\Criteria;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserClaimReasonIdCriteria extends Criteria
{

    private int $reasonId;

    public function __construct(int $reasonId)
    {
        $this->reasonId = $reasonId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(UserClaimColumnsEnum::REASON_ID, '=', $this->reasonId);
    }
}
