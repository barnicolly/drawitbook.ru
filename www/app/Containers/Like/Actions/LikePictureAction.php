<?php

namespace App\Containers\Like\Actions;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Like\Tasks\CreateLikeTask;
use App\Containers\Like\Tasks\DeleteLikeByIdTask;
use App\Containers\Like\Tasks\GetLikeByPictureIdTask;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Actions\Action;

class LikePictureAction extends Action
{
    public function __construct(
        private readonly CreateLikeTask $createLikeTask,
        private readonly GetLikeByPictureIdTask $getLikeByPictureIdTask,
        private readonly DeleteLikeByIdTask $deleteLikeByIdTask,
    ) {
    }

    /**
     * @throws RepositoryException
     */
    public function run(int $pictureId, bool $turnOn, UserDto $userDto): void
    {
        $activity = $this->getLikeByPictureIdTask->run($pictureId, $userDto);
        if (!$activity) {
            if ($turnOn) {
                $this->createLikeTask->run($pictureId, $userDto);
            }
        } elseif (!$turnOn) {
            $this->deleteLikeByIdTask->run($activity->id);
        }
    }
}
