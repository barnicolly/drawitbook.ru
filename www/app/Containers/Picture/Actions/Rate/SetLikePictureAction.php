<?php

namespace App\Containers\Picture\Actions\Rate;

use App\Containers\Rate\Actions\RatePictureAction;
use App\Containers\Rate\Enums\RateEnum;
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
        app(RatePictureAction::class)->run($pictureId, $turnOn, RateEnum::LIKE, $userDto);
    }

}


