<?php

declare(strict_types=1);

namespace App\Ship\Parents\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

final class WhereStringCriteria extends Criteria
{
    public function __construct(private readonly string $field, private readonly string $value)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where($this->field, '=', $this->value);
    }
}
