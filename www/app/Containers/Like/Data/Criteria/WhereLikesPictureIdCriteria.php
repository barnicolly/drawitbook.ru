<?php

namespace App\Containers\Like\Data\Criteria;

use App\Containers\Like\Enums\LikesColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereLikesPictureIdCriteria extends Criteria
{
    public function __construct(private readonly int $pictureId)
    {
    }

    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where(LikesColumnsEnum::PICTURE_ID, '=', $this->pictureId);
    }
}
