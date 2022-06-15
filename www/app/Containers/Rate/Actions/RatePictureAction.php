<?php

namespace App\Containers\Rate\Actions;

use App\Containers\Rate\Models\UserActivityModel;
use App\Containers\Rate\Tasks\GetUserActivityByPictureIdTask;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\DB;

class RatePictureAction extends Action
{

    public function run(int $pictureId, bool $turnOn, int $rate, UserDto $userDto): void
    {
        $activity = app(GetUserActivityByPictureIdTask::class)->run($pictureId, $userDto);
        if (!$activity) {
            if ($turnOn) {
                //                todo-misha вынести в таск;
                //                todo-misha создание через dto;
                $activity = new UserActivityModel();
                $activity->picture_id = $pictureId;
                $activity->ip = DB::raw("inet_aton($userDto->ip)");
                $activity->user_id = $userDto->id;
                $activity->activity = $rate;
                $activity->save();
            }
        } else {
            //                todo-misha вынести в таски;
            if ($turnOn) {
                $activity->activity = $rate;
                $activity->save();
            } else {
                $activity->delete();
            }
        }
    }

}


