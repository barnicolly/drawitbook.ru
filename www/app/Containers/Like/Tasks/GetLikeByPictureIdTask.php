<?php

declare(strict_types=1);

namespace App\Containers\Like\Tasks;

use App\Containers\Like\Data\Repositories\LikesRepository;
use App\Containers\Like\Enums\LikesColumnsEnum;
use App\Containers\Like\Models\LikesModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Criterias\WhereInetNtoaIpCriteria;
use App\Ship\Parents\Criterias\WhereIntCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

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
            ? new WhereIntCriteria(LikesColumnsEnum::USER_ID, $user->id)
            : new WhereInetNtoaIpCriteria(LikesColumnsEnum::IP, $user->ip);
        $this->repository->pushCriteria(new WhereIntCriteria(LikesColumnsEnum::PICTURE_ID, $pictureId))
            ->pushCriteria($userCriteria);
        return $this->repository->first();
    }
}
