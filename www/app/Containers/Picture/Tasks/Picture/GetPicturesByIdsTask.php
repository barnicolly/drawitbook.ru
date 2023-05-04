<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenTagsIdsTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Support\Collection;

class GetPicturesByIdsTask extends Task
{
    public function __construct(protected PictureRepository $repository, private readonly GetHiddenTagsIdsTask $getHiddenTagsIdsTask)
    {
    }

    public function run(array $ids, bool $withHiddenTags): Collection
    {
        $locale = app()->getLocale();
        return $this->repository
            ->with([
                'flags',
                'extensions',
                'tags.flags',
                'tags' => function (BuilderContract $q) use ($locale, $withHiddenTags): void {
                    if ($locale === LangEnum::EN) {
                        $q->whereNotNull(TagsColumnsEnum::SLUG_EN);
                    }
                    if (!$withHiddenTags) {
                        $tagsHiddenIds = $this->getHiddenTagsIdsTask->run();
                        if ($tagsHiddenIds) {
                            $q->whereNotIn(TagsColumnsEnum::tID, $tagsHiddenIds);
                        }
                    }
                },
            ])
            ->findWhereIn(PictureColumnsEnum::ID, $ids);
    }
}
