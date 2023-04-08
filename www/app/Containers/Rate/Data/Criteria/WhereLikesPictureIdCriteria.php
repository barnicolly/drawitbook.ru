<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\LikesColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereLikesPictureIdCriteria extends Criteria
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
        return $model->where(LikesColumnsEnum::PICTURE_ID, '=', $this->pictureId);
    }
}
