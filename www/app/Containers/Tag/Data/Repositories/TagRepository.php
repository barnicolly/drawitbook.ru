<?php

declare(strict_types=1);

namespace App\Containers\Tag\Data\Repositories;

use App\Containers\Tag\Models\TagsModel;
use App\Ship\Parents\Repositories\Repository;

final class TagRepository extends Repository
{
    public function model(): string
    {
        return TagsModel::class;
    }
}
