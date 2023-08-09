<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenTagsIdsTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Support\Collection;

final class GetPicturesByIdsTask extends Task
{
    public function __construct(private readonly GetHiddenTagsIdsTask $getHiddenTagsIdsTask)
    {
    }

    public function run(array $ids, bool $withHiddenTags): Collection
    {
        $locale = app()->getLocale();
        return PictureModel::with([
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
            ->whereIn(PictureColumnsEnum::ID, $ids)
            ->get()
            ->sortBy(static fn (PictureModel $model): int|string|false => array_search($model->getKey(), $ids, true));
    }
}
