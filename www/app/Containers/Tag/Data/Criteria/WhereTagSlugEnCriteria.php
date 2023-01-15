<?php

namespace App\Containers\Tag\Data\Criteria;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereTagSlugEnCriteria extends Criteria
{
    private string $tagSeoName;

    public function __construct(string $tagSeoName)
    {
        $this->tagSeoName = $tagSeoName;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->where(SprTagsColumnsEnum::tSLUG_EN, '=', $this->tagSeoName);
    }
}
