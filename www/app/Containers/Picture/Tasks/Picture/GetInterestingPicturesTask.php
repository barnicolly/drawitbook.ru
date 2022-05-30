<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Criteria\Picture\WherePictureExcludeIdCriteria;
use App\Containers\Picture\Data\Criteria\Picture\WherePictureNotDeletedCriteria;
use App\Containers\Picture\Data\Criteria\Picture\WherePictureShowInMainPageCriteria;
use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Ship\Parents\Tasks\Task;

class GetInterestingPicturesTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $excludeId, int $limit): array
    {
        $this->repository->pushCriteria(new WherePictureExcludeIdCriteria($excludeId))
            ->pushCriteria(new WherePictureShowInMainPageCriteria())
            ->pushCriteria(new WherePictureNotDeletedCriteria());
        return $this->repository->take($limit)->get()->toArray();
    }
}


