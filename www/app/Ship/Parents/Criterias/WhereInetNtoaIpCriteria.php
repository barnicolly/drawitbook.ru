<?php

namespace App\Ship\Parents\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereInetNtoaIpCriteria extends Criteria
{
    public function __construct(private readonly string $field, private readonly string $ip)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereRaw('INET_NTOA(' . $this->field . ") = {$this->ip}");
    }
}
