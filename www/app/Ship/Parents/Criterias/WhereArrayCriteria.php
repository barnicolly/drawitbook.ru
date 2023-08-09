<?php

declare(strict_types=1);

namespace App\Ship\Parents\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereArrayCriteria extends Criteria
{
    public function __construct(private readonly string $field, private readonly array $array)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereIn($this->field, $this->array);
    }
}
