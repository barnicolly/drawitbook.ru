<?php

declare(strict_types=1);

namespace App\Containers\Like\Tasks;

use App\Containers\Like\Models\LikesModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

class CreateLikeTask extends Task
{
    public function run(int $pictureId, UserDto $userDto): ?LikesModel
    {
        $activity = new LikesModel();
        $activity->picture_id = $pictureId;
        $activity->ip = DB::raw("inet_aton({$userDto->ip})");
        $activity->user_id = $userDto->id;
        $activity->save();
        return $activity;
    }
}
