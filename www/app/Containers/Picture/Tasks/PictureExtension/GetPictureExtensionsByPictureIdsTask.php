<?php

namespace App\Containers\Picture\Tasks\PictureExtension;

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

    /**
     * @param array $ids
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(array $ids): array
    {
        return $this->repository->findWhereIn(PictureExtensionsColumnsEnum::PICTURE_ID, $ids)->toArray();
    }
}


