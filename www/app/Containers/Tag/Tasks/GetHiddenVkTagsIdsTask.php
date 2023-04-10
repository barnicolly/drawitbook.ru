<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class GetHiddenVkTagsIdsTask extends Task
{
    public function __construct(protected TagRepository $repository)
    {
    }

    public function run(): array
    {
        return $this->repository->flagged(FlagsEnum::TAG_HIDDEN_VK)->get()->pluck(SprTagsColumnsEnum::ID)->toArray();
    }
}
