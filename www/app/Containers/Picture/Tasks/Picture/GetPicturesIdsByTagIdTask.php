<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Criteria\Picture\JoinPictureTagCriteria;
use App\Containers\Picture\Data\Criteria\PictureTag\WhereTagIdCriteria;
use App\Containers\Picture\Data\Repositories\PictureRepository;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Tasks\Task;

class GetPicturesIdsByTagIdTask extends Task
{

    protected PictureRepository $repository;

    public function __construct(PictureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $tagId
     * @param int $limit
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $tagId, int $limit): array
    {
        $this->repository->pushCriteria(new JoinPictureTagCriteria())
            ->pushCriteria(new WhereTagIdCriteria($tagId));
        return $this->repository->take($limit)->get([PictureColumnsEnum::$tId])->pluck(PictureColumnsEnum::ID)->toArray();
    }
}


