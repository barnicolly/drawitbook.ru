<?php

namespace App\Containers\Rate\Actions;

use App\Containers\Rate\Tasks\CreateLikeTask;
use App\Containers\Rate\Tasks\DeleteLikeByIdTask;
use App\Containers\Rate\Tasks\GetLikeByPictureIdTask;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Actions\Action;

class LikePictureAction extends Action
{

    private CreateLikeTask $createLikeTask;
    private GetLikeByPictureIdTask $getLikeByPictureIdTask;
    private DeleteLikeByIdTask $deleteLikeByIdTask;

    /**
     * @param CreateLikeTask $createLikeTask
     * @param GetLikeByPictureIdTask $getLikeByPictureIdTask
     * @param DeleteLikeByIdTask $deleteLikeByIdTask
     */
    public function __construct(
        CreateLikeTask $createLikeTask,
        GetLikeByPictureIdTask $getLikeByPictureIdTask,
        DeleteLikeByIdTask $deleteLikeByIdTask
    ) {
        $this->createLikeTask = $createLikeTask;
        $this->getLikeByPictureIdTask = $getLikeByPictureIdTask;
        $this->deleteLikeByIdTask = $deleteLikeByIdTask;
    }

    /**
     * @param int $pictureId
     * @param bool $turnOn
     * @param UserDto $userDto
     * @return void
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(int $pictureId, bool $turnOn, UserDto $userDto): void
    {
        $activity = $this->getLikeByPictureIdTask->run($pictureId, $userDto);
        if (!$activity) {
            if ($turnOn) {
                $this->createLikeTask->run($pictureId, $userDto);
            }
        } else {
            if (!$turnOn) {
                $this->deleteLikeByIdTask->run($activity->id);
            }
        }
    }

}


