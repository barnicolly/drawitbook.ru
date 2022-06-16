<?php

namespace App\Containers\Picture\Actions\Rate;

use App\Containers\Rate\Actions\LikePictureAction;
use App\Containers\User\Data\Dto\UserDto;
use App\Containers\User\Services\UserService;
use App\Ship\Parents\Actions\Action;

class SetLikePictureAction extends Action
{

    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function run(int $pictureId, bool $turnOn): void
    {
        $userDto = new UserDto(ip: $this->userService->getIp(), id: 0);
        app(LikePictureAction::class)->run($pictureId, $turnOn, $userDto);
    }

}


