<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenTagsIdsTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;

final class GetPictureTagsWithCountArtTask extends Task
{
    public function __construct(private readonly GetHiddenTagsIdsTask $getHiddenTagsIdsTask)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $limit, string $locale): array
    {
        $tagsHiddenIds = $this->getHiddenTagsIdsTask->run();
        $columns = new Collection();
        $columns->push(TagsColumnsEnum::tID);
        if ($locale === LangEnum::EN) {
            $columns->push(TagsColumnsEnum::tNAME_EN . ' as name');
            $columns->push(TagsColumnsEnum::tSLUG_EN . ' as seo');
        } else {
            $columns->push(TagsColumnsEnum::tNAME);
            $columns->push(TagsColumnsEnum::tSEO);
        }
        return TagsModel::withCount('pictures')
            ->when($locale === LangEnum::EN, static function (Builder $query): void {
                $query->whereNotNull(TagsColumnsEnum::tSLUG_EN);
            })
            ->whereNotIn(TagsColumnsEnum::tID, $tagsHiddenIds)
            ->groupBy(TagsColumnsEnum::tID)
            ->orderBy('pictures_count', 'desc')
            ->take($limit)
            ->addSelect($columns->toArray())
            ->get()
            ->toArray();
    }
}
