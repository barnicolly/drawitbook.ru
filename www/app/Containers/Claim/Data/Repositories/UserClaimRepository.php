<?php

declare(strict_types=1);

namespace App\Containers\Claim\Data\Repositories;

use App\Containers\Claim\Models\UserClaimModel;
use App\Ship\Parents\Repositories\Repository;

final class UserClaimRepository extends Repository
{
    public function model(): string
    {
        return UserClaimModel::class;
    }
}
