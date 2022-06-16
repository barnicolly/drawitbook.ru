<?php

namespace App\Containers\Rate\Tasks;

use App\Containers\Rate\Models\LikesModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

class CreateLikeTask extends Task
{

    /**
     * @param int $pictureId
     * @param UserDto $userDto
     * @return LikesModel|null
     */
    public function run(int $pictureId, UserDto $userDto): ?LikesModel
    {
        $activity = new LikesModel();
        $activity->picture_id = $pictureId;
        $activity->ip = DB::raw("inet_aton($userDto->ip)");
        $activity->user_id = $userDto->id;
        $activity->save();
        return $activity;
    }
}


