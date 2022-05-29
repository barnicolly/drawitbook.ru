<?php

namespace App\Containers\Picture\Tasks;

use App\Containers\Picture\Data\Criteria\WherePictureExcludeIdCriteria;
use App\Containers\Picture\Data\Criteria\WherePictureNotDeletedCriteria;
use App\Containers\Picture\Data\Criteria\WherePictureShowInMainPageCriteria;
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


