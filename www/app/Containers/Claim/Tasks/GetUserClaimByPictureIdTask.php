<?php

declare(strict_types=1);

namespace App\Containers\Claim\Tasks;

use App\Containers\Claim\Data\Repositories\UserClaimRepository;
use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Criterias\WhereInetAtonIpCriteria;
use App\Ship\Parents\Criterias\WhereIntCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

class GetUserClaimByPictureIdTask extends Task
{
    public function __construct(protected UserClaimRepository $repository)
    {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $pictureId, int $reasonId, UserDto $user): ?UserClaimModel
    {
        $userCriteria = $user->id
            ? new WhereIntCriteria(UserClaimColumnsEnum::USER_ID, $user->id)
            : new WhereInetAtonIpCriteria(UserClaimColumnsEnum::IP, $user->ip);
        $this->repository->pushCriteria(new WhereIntCriteria(UserClaimColumnsEnum::REASON_ID, $reasonId))
            ->pushCriteria(new WhereIntCriteria(UserClaimColumnsEnum::PICTURE_ID, $pictureId))
            ->pushCriteria($userCriteria);
        return $this->repository->first();
    }
}
