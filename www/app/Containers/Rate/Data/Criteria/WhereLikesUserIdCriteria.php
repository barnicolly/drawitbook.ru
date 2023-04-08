<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\LikesColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereLikesUserIdCriteria extends Criteria
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
        return $model->where(LikesColumnsEnum::USER_ID, '=', $this->userId);
    }
}
