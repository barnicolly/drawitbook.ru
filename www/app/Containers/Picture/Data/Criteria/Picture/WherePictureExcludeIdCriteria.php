<?php

namespace App\Containers\Picture\Data\Criteria\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureExcludeIdCriteria extends Criteria
{
    private int $excludeId;

    public function __construct(int $excludeId)
    {
        $this->excludeId = $excludeId;
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where(PictureColumnsEnum::tId, '!=', $this->excludeId);
    }
}
