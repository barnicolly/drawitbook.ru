<?php

namespace App\Containers\Picture\Tasks\PictureExtension;

use App\Containers\Picture\Data\Criteria\PictureExtension\WherePictureExtensionNotDeletedCriteria;
use App\Containers\Picture\Data\Repositories\PictureExtensionRepository;
use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Parents\Tasks\Task;

class GetPictureExtensionsByPictureIdsTask extends Task
{

    protected PictureExtensionRepository $repository;

    public function __construct(PictureExtensionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $ids): array
    {
        $this->repository->pushCriteria(new WherePictureExtensionNotDeletedCriteria());
        return $this->repository->findWhereIn(PictureExtensionsColumnsEnum::PICTURE_ID, $ids)->toArray();
    }
}


