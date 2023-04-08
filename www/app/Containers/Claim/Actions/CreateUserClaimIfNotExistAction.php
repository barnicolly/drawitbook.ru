<?php

namespace App\Containers\Claim\Actions;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Claim\Tasks\CreateUserClaimTask;
use App\Containers\Claim\Tasks\GetUserClaimByPictureIdTask;
use App\Containers\User\Data\Dto\UserDto;
use App\Containers\User\Tasks\GetUserIpFromRequestTask;
use App\Ship\Parents\Actions\Action;

class CreateUserClaimIfNotExistAction extends Action
{

    private GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask;
    private CreateUserClaimTask $createUserClaimTask;
    private GetUserIpFromRequestTask $getUserIpFromRequestTask;

    /**
     * @param GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask
     * @param CreateUserClaimTask $createUserClaimTask
     * @param GetUserIpFromRequestTask $getUserIpFromRequestTask
     */
    public function __construct(
        GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask,
        CreateUserClaimTask $createUserClaimTask,
        GetUserIpFromRequestTask $getUserIpFromRequestTask
    ) {
        $this->getUserClaimByPictureIdTask = $getUserClaimByPictureIdTask;
        $this->createUserClaimTask = $createUserClaimTask;
        $this->getUserIpFromRequestTask = $getUserIpFromRequestTask;
    }

    /**
     * @throws UnknownProperties
     * @throws RepositoryException
     */
    public function run(int $pictureId, int $reasonId): void
    {
        $userDto = new UserDto(ip: $this->getUserIpFromRequestTask->run());
        $claim = $this->getUserClaimByPictureIdTask->run($pictureId, $reasonId, $userDto);
        if ($claim === null) {
            $this->createUserClaimTask->run($pictureId, $reasonId, $userDto);
        }
    }

}


