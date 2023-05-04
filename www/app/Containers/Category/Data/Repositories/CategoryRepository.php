<?php

namespace App\Containers\Category\Data\Repositories;

use App\Containers\Category\Models\CategoryModel;
use App\Ship\Parents\Repositories\Repository;

class CategoryRepository extends Repository
{
    public function model(): string
    {
        return CategoryModel::class;
    }
}
