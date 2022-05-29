<?php

namespace App\Containers\Picture\Data\Repositories;

use App\Containers\Picture\Models\PictureModel;
use App\Ship\Parents\Repositories\Repository;

class PictureRepository extends Repository
{

    public function model(): string
    {
        return PictureModel::class;
    }
}
