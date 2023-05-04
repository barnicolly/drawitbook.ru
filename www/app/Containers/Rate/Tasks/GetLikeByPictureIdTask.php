<?php

namespace App\Containers\Rate\Tasks;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Rate\Data\Criteria\WhereLikesIpCriteria;
use App\Containers\Rate\Data\Criteria\WhereLikesPictureIdCriteria;
use App\Containers\Rate\Data\Criteria\WhereLikesUserIdCriteria;
use App\Containers\Rate\Data\Repositories\LikesRepository;
use App\Containers\Rate\Models\LikesModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Tasks\Task;

class GetLikeByPictureIdTask extends Task
{
    public function __construct(protected LikesRepository $repository)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $pictureId, UserDto $user): ?LikesModel
    {
        $userCriteria = $user->id
            ? new WhereLikesUserIdCriteria($user->id)
            : new WhereLikesIpCriteria($user->ip);
        $this->repository->pushCriteria(new WhereLikesPictureIdCriteria($pictureId))
            ->pushCriteria($userCriteria);
        return $this->repository->first();
    }
}
