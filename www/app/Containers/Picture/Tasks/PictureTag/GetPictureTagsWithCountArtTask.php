<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Picture\Data\Criteria\PictureTag\JoinTagCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WhereNotTagIdsCriteria;
use App\Containers\Picture\Data\Repositories\PictureTagRepository;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Data\Criteria\WhereTagSlugEnIsNotNullCriteria;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenTagsIdsTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetPictureTagsWithCountArtTask extends Task
{
    public function __construct(protected PictureTagRepository $repository, private readonly GetHiddenTagsIdsTask $getHiddenTagsIdsTask)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $limit, string $locale): array
    {
        $tagsHiddenIds = $this->getHiddenTagsIdsTask->run();

        $columns = new Collection();
        $columns->push(DB::raw('count("' . PictureTagsColumnsEnum::tId . '") as count'));
        if ($locale === LangEnum::EN) {
            $columns->push(TagsColumnsEnum::tNAME_EN . ' as name');
            $columns->push(TagsColumnsEnum::tSLUG_EN . ' as seo');
        } else {
            $columns->push(TagsColumnsEnum::tNAME);
            $columns->push(TagsColumnsEnum::tSEO);
        }
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnIsNotNullCriteria());
        }
        $this->repository->scopeQuery(static fn ($model) => $model
            ->groupBy(TagsColumnsEnum::tID)
            ->orderBy('count', 'desc'));
        return $this->repository->pushCriteria(new WhereNotTagIdsCriteria($tagsHiddenIds))
            ->pushCriteria(new JoinTagCriteria())
            ->take($limit)
            ->get($columns->toArray())->toArray();
    }
}
