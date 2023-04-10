<?php

namespace App\Containers\Tag\Tests\Traits;

use App\Containers\Tag\Models\SprTagsModel;

trait CreateTagTrait
{
    public function createTag(array $overrideData = []): SprTagsModel
    {
        return SprTagsModel::factory()->create($overrideData);
    }
}
