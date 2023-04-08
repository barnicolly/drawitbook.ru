<?php

namespace App\Containers\Claim\Data\Criteria;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserClaimPictureIdCriteria extends Criteria
{

    private int $pictureId;

    public function __construct(int $pictureId)
    {
        $this->pictureId = $pictureId;
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where(UserClaimColumnsEnum::PICTURE_ID, '=', $this->pictureId);
    }
}
