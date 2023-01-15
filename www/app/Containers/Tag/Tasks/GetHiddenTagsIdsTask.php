<?php

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

class GetHiddenTagsIdsTask extends Task
{

    protected TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function run(): array
    {
        return $this->repository->flagged(FlagsEnum::TAG_HIDDEN)->get()->pluck(SprTagsColumnsEnum::ID)->toArray();
    }
}


