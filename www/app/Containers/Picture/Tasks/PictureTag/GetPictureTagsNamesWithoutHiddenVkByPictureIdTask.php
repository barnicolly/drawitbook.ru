<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Picture\Data\Criteria\PictureTag\JoinTagCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WhereNotTagIdsCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WherePictureIdCriteria;
use App\Containers\Picture\Data\Repositories\PictureTagRepository;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Tasks\GetHiddenVkTagsIdsTask;
use App\Ship\Parents\Tasks\Task;

class GetPictureTagsNamesWithoutHiddenVkByPictureIdTask extends Task
{

    protected PictureTagRepository $repository;
    private GetHiddenVkTagsIdsTask $getHiddenVkTagsIdsTask;

    public function __construct(PictureTagRepository $repository, GetHiddenVkTagsIdsTask $getHiddenVkTagsIdsTask)
    {
        $this->repository = $repository;
        $this->getHiddenVkTagsIdsTask = $getHiddenVkTagsIdsTask;
    }

    /**
     * @param int $artId
     * @return array
     * @throws RepositoryException
     */
    public function run(int $artId): array
    {
        $hiddenVkTagIds = $this->getHiddenVkTagsIdsTask->run();
        $this->repository->pushCriteria(new WherePictureIdCriteria($artId))
            ->pushCriteria(new WhereNotTagIdsCriteria($hiddenVkTagIds))
            ->pushCriteria(new JoinTagCriteria());
        return $this->repository->get([SprTagsColumnsEnum::tNAME])
            ->pluck(SprTagsColumnsEnum::NAME)
            ->toArray();
    }
}


