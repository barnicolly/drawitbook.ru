<?php

namespace App\Containers\Rate\Tasks;

use App\Containers\Rate\Data\Repositories\LikesRepository;
use App\Ship\Parents\Tasks\Task;

class DeleteLikeByIdTask extends Task
{

    public function __construct(protected LikesRepository $repository)
    {
    }

    public function run(int $likeId): void
    {
        $this->repository->delete($likeId);
    }
}


