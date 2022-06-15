<?php

namespace App\Containers\Claim\Data\Criteria;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WhereUserClaimIpCriteria extends Criteria
{

    private string $ip;

    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    public function apply($model, PrettusRepositoryInterface $repository)
    {
        return $model->whereRaw(UserClaimColumnsEnum::IP . " = inet_aton($this->ip)");
    }
}
