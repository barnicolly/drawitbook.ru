<?php

namespace App\Containers\Picture\Data\Criteria\PictureTag;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereNotTagIdsCriteria extends Criteria
{
    private array $tagIds;

    public function __construct(array $tagIds)
    {
        $this->tagIds = $tagIds;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereNotIn(PictureTagsColumnsEnum::tTAG_ID, $this->tagIds);
    }
}
