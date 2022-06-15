<?php

namespace App\Containers\Claim\Tasks;

use App\Containers\Claim\Data\Criteria\WhereUserClaimIpCriteria;
use App\Containers\Claim\Data\Criteria\WhereUserClaimPictureIdCriteria;
use App\Containers\Claim\Data\Criteria\WhereUserClaimReasonIdCriteria;
use App\Containers\Claim\Data\Criteria\WhereUserClaimUserIdCriteria;
use App\Containers\Claim\Data\Repositories\UserClaimRepository;
use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Tasks\Task;

class GetUserClaimByPictureIdTask extends Task
{

    protected UserClaimRepository $repository;

    public function __construct(UserClaimRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $pictureId
     * @param int $reasonId
     * @param UserDto $user
     * @return UserClaimModel|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $pictureId, int $reasonId, UserDto $user): ?UserClaimModel
    {
        $userCriteria = $user->id
            ? new WhereUserClaimUserIdCriteria($user->id)
            : new WhereUserClaimIpCriteria($user->ip);
        $this->repository->pushCriteria(new WhereUserClaimReasonIdCriteria($reasonId))
            ->pushCriteria(new WhereUserClaimPictureIdCriteria($pictureId))
            ->pushCriteria($userCriteria);
        return $this->repository->first();
    }
}


