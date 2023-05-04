<?php

namespace App\Containers\Picture\Data\Criteria\PictureTag;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class JoinTagCriteria extends Criteria
{
    /**
     * @param Builder $model
     * @param PrettusRepositoryInterface $repository
     *
     * @return Builder
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->join(TagsColumnsEnum::TABlE, TagsColumnsEnum::tId, '=', PictureTagsColumnsEnum::tTAG_ID);
    }
}
