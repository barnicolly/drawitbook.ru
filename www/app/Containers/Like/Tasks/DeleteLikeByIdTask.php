<?php

declare(strict_types=1);

namespace App\Containers\Like\Tasks;

use App\Containers\Like\Data\Repositories\LikesRepository;
use App\Ship\Parents\Tasks\Task;

final class DeleteLikeByIdTask extends Task
{
    public function __construct(protected LikesRepository $repository)
    {
    }

    public function run(int $likeId): void
    {
        $this->repository->delete($likeId);
    }
}
