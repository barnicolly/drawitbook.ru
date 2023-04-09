<?php

namespace App\Containers\Picture\Data\Repositories;

use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Ship\Parents\Repositories\Repository;

class PictureExtensionRepository extends Repository
{
    public function model(): string
    {
        return PictureExtensionsModel::class;
    }
}
