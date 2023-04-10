<?php

namespace App\Containers\Tag\Data\Repositories;

use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Parents\Repositories\Repository;

class TagRepository extends Repository
{
    public function model(): string
    {
        return SprTagsModel::class;
    }
}
