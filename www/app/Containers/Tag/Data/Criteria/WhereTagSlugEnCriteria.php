<?php

namespace App\Containers\Tag\Data\Criteria;

use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereTagSlugEnCriteria extends Criteria
{
    public function __construct(private readonly string $tagSeoName)
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
        return $model->where(TagsColumnsEnum::tSLUG_EN, '=', $this->tagSeoName);
    }
}
