<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenVkTagsIdsTask;
use App\Ship\Parents\Tasks\Task;

class GetPictureTagsNamesWithoutHiddenVkByPictureIdTask extends Task
{
    public function __construct(
        private readonly GetHiddenVkTagsIdsTask $getHiddenVkTagsIdsTask
    ) {
    }

    public function run(int $artId): array
    {
//        todo-misha переписать;
        $hiddenVkTagIds = $this->getHiddenVkTagsIdsTask->run();

        return TagsModel
            ::with(
                [
                    'pictures' => function (BuilderContract $q) use ($artId): void {
                        $q->where(PictureColumnsEnum::tId, '=', $artId);
                    },
                ]
            )
            ->whereNotIn(TagsColumnsEnum::tID, $hiddenVkTagIds)
            ->get([TagsColumnsEnum::tID, TagsColumnsEnum::tNAME])
            ->pluck(TagsColumnsEnum::NAME)
            ->toArray();
    }
}
