<?php

namespace App\Containers\Rate\Tasks;

use App\Containers\Rate\Data\Criteria\WhereUserActivityIpCriteria;
use App\Containers\Rate\Data\Criteria\WhereUserActivityIsRateCriteria;
use App\Containers\Rate\Data\Criteria\WhereUserActivityPictureIdCriteria;
use App\Containers\Rate\Data\Criteria\WhereUserActivityUserIdCriteria;
use App\Containers\Rate\Data\Repositories\UserActivityRepository;
use App\Containers\Rate\Models\UserActivityModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Tasks\Task;

class GetUserActivityByPictureIdTask extends Task
{

    protected UserActivityRepository $repository;

    public function __construct(UserActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $pictureId
     * @param UserDto $user
     * @return UserActivityModel|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $pictureId, UserDto $user): ?UserActivityModel
    {
        $userCriteria = $user->id
            ? new WhereUserActivityUserIdCriteria($user->id)
            : new WhereUserActivityIpCriteria($user->ip);
        $this->repository->pushCriteria(new WhereUserActivityIsRateCriteria())
            ->pushCriteria(new WhereUserActivityPictureIdCriteria($pictureId))
            ->pushCriteria($userCriteria);
        return $this->repository->first();
    }
}


