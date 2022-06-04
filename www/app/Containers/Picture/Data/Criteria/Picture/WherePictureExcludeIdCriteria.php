<?php

namespace App\Containers\Picture\Data\Criteria\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WherePictureExcludeIdCriteria extends Criteria
{
    private int $excludeId;

    public function __construct(int $excludeId)
    {
        $this->excludeId = $excludeId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(PictureColumnsEnum::$tId, '!=', $this->excludeId);
    }
}
