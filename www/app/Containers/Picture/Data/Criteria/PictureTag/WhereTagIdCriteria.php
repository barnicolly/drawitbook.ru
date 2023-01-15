<?php

namespace App\Containers\Picture\Data\Criteria\PictureTag;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereTagIdCriteria extends Criteria
{
    private int $tagId;

    public function __construct(int $tagId)
    {
        $this->tagId = $tagId;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(PictureTagsColumnsEnum::tTAG_ID, '=', $this->tagId);
    }
}
