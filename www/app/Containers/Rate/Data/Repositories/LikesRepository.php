<?php

namespace App\Containers\Rate\Data\Repositories;

use App\Containers\Rate\Models\LikesModel;
use App\Ship\Parents\Repositories\Repository;

class LikesRepository extends Repository
{
    public function model(): string
    {
        return LikesModel::class;
    }
}
