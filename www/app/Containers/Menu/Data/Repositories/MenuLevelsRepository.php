<?php

namespace App\Containers\Menu\Data\Repositories;

use App\Containers\Menu\Models\MenuLevelsModel;
use App\Ship\Parents\Repositories\Repository;

class MenuLevelsRepository extends Repository
{
    public function model(): string
    {
        return MenuLevelsModel::class;
    }
}
