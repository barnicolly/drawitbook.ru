<?php

namespace App\Containers\Picture\Tasks\PictureTag;

use App\Containers\Picture\Data\Criteria\PictureTag\JoinTagCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WherePictureIdCriteria;
use App\Containers\Picture\Data\Repositories\PictureTagRepository;
use App\Containers\Tag\Data\Criteria\WhereTagNotHiddenVkCriteria;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Tasks\Task;

class GetPictureTagsNamesWithoutHiddenVkByPictureIdTask extends Task
{

    protected PictureTagRepository $repository;

    public function __construct(PictureTagRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $artId
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $artId): array
    {
        $this->repository->pushCriteria(new WherePictureIdCriteria($artId))
            ->pushCriteria(new JoinTagCriteria())
            ->pushCriteria(new WhereTagNotHiddenVkCriteria());
        return $this->repository->get([SprTagsColumnsEnum::$tNAME])
            ->pluck(SprTagsColumnsEnum::NAME)
            ->toArray();
    }
}


