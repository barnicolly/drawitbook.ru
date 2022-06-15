<?php

namespace App\Containers\Claim\Actions;

use App\Containers\Claim\Tasks\CreateUserClaimTask;
use App\Containers\Claim\Tasks\GetUserClaimByPictureIdTask;
use App\Containers\User\Data\Dto\UserDto;
use App\Containers\User\Services\UserService;
use App\Ship\Parents\Actions\Action;

class CreateUserClaimIfNotExistAction extends Action
{

    private UserService $userService;
    private GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask;
    private CreateUserClaimTask $createUserClaimTask;

    /**
     * @param UserService $userService
     * @param GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask
     * @param CreateUserClaimTask $createUserClaimTask
     */
    public function __construct(
        UserService $userService,
        GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask,
        CreateUserClaimTask $createUserClaimTask
    ) {
        $this->userService = $userService;
        $this->getUserClaimByPictureIdTask = $getUserClaimByPictureIdTask;
        $this->createUserClaimTask = $createUserClaimTask;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $pictureId, int $reasonId): void
    {
        $userDto = new UserDto(ip: $this->userService->getIp());
        $claim = $this->getUserClaimByPictureIdTask->run($pictureId, $reasonId, $userDto);
        if ($claim === null) {
            $this->createUserClaimTask->run($pictureId, $reasonId, $userDto);
        }
    }

}


