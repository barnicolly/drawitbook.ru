<?php

namespace App\Containers\Claim\Tasks;

use App\Containers\Claim\Data\Repositories\UserClaimRepository;
use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\User\Data\Dto\UserDto;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\DB;

class CreateUserClaimTask extends Task
{

    public function __construct(protected UserClaimRepository $repository)
    {
    }

    public function run(int $pictureId, int $reasonId, UserDto $user): UserClaimModel
    {
        $claim = new UserClaimModel();
        $claim->picture_id = $pictureId;
        $claim->ip = DB::raw("inet_aton($user->ip)");
        $claim->reason_id = $reasonId;
        $claim->user_id = $user->id;
        $claim->save();
        return $claim;
    }
}


