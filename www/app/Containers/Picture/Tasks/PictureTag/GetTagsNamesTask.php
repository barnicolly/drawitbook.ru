<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Builder;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenTagsIdsTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

class GetTagsNamesTask extends Task
{
    public function __construct(private readonly GetHiddenTagsIdsTask $getHiddenTagsIdsTask)
    {
    }

    public function run(string $locale): array
    {
        $tagsHiddenIds = $this->getHiddenTagsIdsTask->run();
        $columns = new Collection();
        $columns->push(TagsColumnsEnum::tID);
        if ($locale === LangEnum::EN) {
            $columns->push(TagsColumnsEnum::tNAME_EN . ' as name');
        } else {
            $columns->push(TagsColumnsEnum::tNAME);
        }
        return TagsModel::query()
            ->whereHas('pictures', null, '>', 0)
            ->when($locale === LangEnum::EN, static function (Builder $query): void {
                $query->whereNotNull(TagsColumnsEnum::tSLUG_EN);
            })
            ->whereNotIn(TagsColumnsEnum::tID, $tagsHiddenIds)
            ->addSelect($columns->toArray())
            ->get()
            ->pluck('name')
            ->toArray();
    }
}
