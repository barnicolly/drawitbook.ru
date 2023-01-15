<?php

namespace App\Containers\Tag\Data\Criteria;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereTagIdsCriteria extends Criteria
{
    private array $tagIds;

    public function __construct(array $tagIds)
    {
        $this->tagIds = $tagIds;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereIn(SprTagsColumnsEnum::$tId, $this->tagIds);
    }
}
