<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Criteria\Picture\WherePictureExcludeIdCriteria;
use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class GetInterestingPictureIdsTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $excludeId
     * @param int $limit
     * @return array
     * @throws RepositoryException
     */
    public function run(int $excludeId, int $limit): array
    {
        $this->repository->pushCriteria(new WherePictureExcludeIdCriteria($excludeId));
        return $this->repository->take($limit)
            ->flagged(FlagsEnum::PICTURE_COMMON)
            ->get()
            ->pluck(PictureColumnsEnum::ID)
            ->toArray();
    }
}


