<?php

namespace App\Containers\Picture\Actions\Rate;

use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Containers\Rate\Actions\LikePictureAction;
use App\Containers\User\Data\Dto\UserDto;
use App\Containers\User\Tasks\GetUserIpFromRequestTask;
use App\Ship\Parents\Actions\Action;

class SetLikePictureAction extends Action
{

    public function __construct(private readonly GetUserIpFromRequestTask $getUserIpFromRequestTask, private readonly LikePictureAction $likePictureAction)
    {
    }

    /**
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    public function run(int $pictureId, bool $turnOn): void
    {
        $userDto = new UserDto(ip: $this->getUserIpFromRequestTask->run());
        $this->likePictureAction->run($pictureId, $turnOn, $userDto);
    }

}


