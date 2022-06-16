<?php

namespace App\Containers\Rate\Tasks;

use App\Containers\Rate\Data\Repositories\LikesRepository;
use App\Ship\Parents\Tasks\Task;

class DeleteLikeByIdTask extends Task
{

    protected LikesRepository $repository;

    public function __construct(LikesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $likeId
     * @return void
     */
    public function run(int $likeId): void
    {
        $this->repository->delete($likeId);
    }
}


