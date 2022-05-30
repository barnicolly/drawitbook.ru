<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Criteria\Picture\WherePictureNotDeletedCriteria;
use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Tasks\Task;

class GetPicturesByIdsTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $ids): array
    {
        $this->repository->pushCriteria(new WherePictureNotDeletedCriteria());
        return $this->repository->findWhereIn(PictureColumnsEnum::ID, $ids)->toArray();
    }
}


