<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Picture\Data\Criteria\PictureTag\JoinTagCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WhereNotTagIdsCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WherePictureIdsCriteria;
use App\Containers\Picture\Data\Repositories\PictureTagRepository;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Data\Criteria\WhereTagSlugEnIsNotNullCriteria;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenTagsIdsTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class GetPictureTagsByPictureIdsTask extends Task
{

    protected PictureTagRepository $repository;
    private GetHiddenTagsIdsTask $getHiddenTagsIdsTask;

    public function __construct(PictureTagRepository $repository, GetHiddenTagsIdsTask $getHiddenTagsIdsTask)
    {
        $this->repository = $repository;
        $this->getHiddenTagsIdsTask = $getHiddenTagsIdsTask;
    }

    /**
     * @param array $artIds
     * @param bool $withHidden
     * @param string $locale
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(array $artIds, bool $withHidden, string $locale): array
    {
        $columns = new Collection();
        $columns->push(PictureTagsColumnsEnum::tId)
            ->push(PictureTagsColumnsEnum::tPICTURE_ID)
            ->push(PictureTagsColumnsEnum::tTAG_ID);
        if ($locale === LangEnum::EN) {
            $columns->push(SprTagsColumnsEnum::tNAME_EN . ' as name');
            $columns->push(SprTagsColumnsEnum::tSLUG_EN . ' as seo');
        } else {
            $columns->push(SprTagsColumnsEnum::tNAME);
            $columns->push(SprTagsColumnsEnum::tSEO);
        }
        if ($locale === LangEnum::EN) {
            $this->repository->pushCriteria(new WhereTagSlugEnIsNotNullCriteria());
        }

        if (!$withHidden) {
            $tagsHiddenIds = $this->getHiddenTagsIdsTask->run();
            $this->repository->pushCriteria(new WhereNotTagIdsCriteria($tagsHiddenIds));
        }

        return $this->repository->pushCriteria(new WherePictureIdsCriteria($artIds))
            ->pushCriteria(new JoinTagCriteria())
            ->get($columns->toArray())->toArray();
    }
}


