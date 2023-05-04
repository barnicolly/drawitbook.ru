<?php

namespace App\Containers\Tag\Tests\Traits;

use App\Containers\Tag\Models\TagsModel;

trait CreateTagTrait
{
    public function createTag(array $overrideData = []): TagsModel
    {
        return TagsModel::factory()->create($overrideData);
    }
}
