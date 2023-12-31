<?php

declare(strict_types=1);

namespace App\Containers\Tag\Tasks;

use App\Containers\Tag\Data\Repositories\TagRepository;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;

final class GetHiddenTagsIdsTask extends Task
{
    public function __construct(protected TagRepository $repository)
    {
    }

    public function run(): array
    {
        return $this->repository->flagged(FlagsEnum::TAG_HIDDEN)->get()->pluck(TagsColumnsEnum::ID)->toArray();
    }
}
