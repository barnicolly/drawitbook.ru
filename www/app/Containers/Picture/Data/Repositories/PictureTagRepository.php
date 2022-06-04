<?php

namespace App\Containers\Picture\Data\Repositories;

use App\Containers\Picture\Models\PictureTagsModel;
use App\Ship\Parents\Repositories\Repository;

class PictureTagRepository extends Repository
{

    public function model(): string
    {
        return PictureTagsModel::class;
    }
}
