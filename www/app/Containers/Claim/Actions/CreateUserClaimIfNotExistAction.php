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
    public function __construct(private readonly GetUserClaimByPictureIdTask $getUserClaimByPictureIdTask, private readonly CreateUserClaimTask $createUserClaimTask, private readonly GetUserIpFromRequestTask $getUserIpFromRequestTask)
    {
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
