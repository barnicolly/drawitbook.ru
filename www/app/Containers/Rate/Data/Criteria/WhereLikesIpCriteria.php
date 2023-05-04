<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\LikesColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereLikesIpCriteria extends Criteria
{
    public function __construct(private readonly string $ip)
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
        return $model->whereRaw('INET_NTOA(' . LikesColumnsEnum::IP . ") = {$this->ip}");
    }
}
