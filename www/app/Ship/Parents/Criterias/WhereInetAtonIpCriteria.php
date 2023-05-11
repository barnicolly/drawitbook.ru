<?php

namespace App\Ship\Parents\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereInetAtonIpCriteria extends Criteria
{
    public function __construct(private readonly string $field, private readonly string $ip)
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
        return $model->whereRaw($this->field . " = inet_aton({$this->ip})");
    }
}
