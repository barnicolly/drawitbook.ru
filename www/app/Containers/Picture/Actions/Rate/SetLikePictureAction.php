<?php

namespace App\Containers\Picture\Actions\Rate;

use App\Containers\Rate\Actions\LikePictureAction;
use App\Containers\User\Data\Dto\UserDto;
use App\Containers\User\Tasks\GetUserIpFromRequestTask;
use App\Ship\Parents\Actions\Action;

class SetLikePictureAction extends Action
{

    private GetUserIpFromRequestTask $getUserIpFromRequestTask;
    private LikePictureAction $likePictureAction;

    /**
     * @param GetUserIpFromRequestTask $getUserIpFromRequestTask
     * @param LikePictureAction $likePictureAction
     */
    public function __construct(
        GetUserIpFromRequestTask $getUserIpFromRequestTask,
        LikePictureAction $likePictureAction
    ) {
        $this->getUserIpFromRequestTask = $getUserIpFromRequestTask;
        $this->likePictureAction = $likePictureAction;
    }

    /**
     * @param int $pictureId
     * @param bool $turnOn
     * @return void
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function run(int $pictureId, bool $turnOn): void
    {
        $userDto = new UserDto(ip: $this->getUserIpFromRequestTask->run(), id: 0);
        $this->likePictureAction->run($pictureId, $turnOn, $userDto);
    }

}


