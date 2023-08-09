<?php

declare(strict_types=1);

namespace App\Containers\Like\Data\Repositories;

use App\Containers\Like\Models\LikesModel;
use App\Ship\Parents\Repositories\Repository;

class LikesRepository extends Repository
{
    public function model(): string
    {
        return LikesModel::class;
    }
}
