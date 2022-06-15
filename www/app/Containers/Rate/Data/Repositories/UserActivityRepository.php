<?php

namespace App\Containers\Rate\Data\Repositories;

use App\Containers\Rate\Models\UserActivityModel;
use App\Ship\Parents\Repositories\Repository;

class UserActivityRepository extends Repository
{

    public function model(): string
    {
        return UserActivityModel::class;
    }
}
