<?php

namespace App\Containers\Rate\Data\Criteria;

use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserActivityIpCriteria extends Criteria
{

    private string $ip;

    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereRaw("INET_NTOA(" . UserActivityColumnsEnum::IP . ") = $this->ip");
    }
}
