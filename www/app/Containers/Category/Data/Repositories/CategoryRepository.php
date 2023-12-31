<?php

declare(strict_types=1);

namespace App\Containers\Category\Data\Repositories;

use App\Containers\Category\Models\CategoryModel;
use App\Ship\Parents\Repositories\Repository;

final class CategoryRepository extends Repository
{
    public function model(): string
    {
        return CategoryModel::class;
    }
}
