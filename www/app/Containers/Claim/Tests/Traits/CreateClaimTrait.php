<?php

namespace App\Containers\Claim\Tests\Traits;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Containers\Claim\Models\SprClaimReasonModel;
use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\User\Tasks\GetUserIpFromRequestTask;
use Illuminate\Support\Facades\DB;

trait CreateClaimTrait
{
    public function createUserClaim(
        PictureModel $picture,
        SprClaimReasonModel $reason,
        array $data = [],
    ): UserClaimModel {
        $ip = app(GetUserIpFromRequestTask::class)->run();
        $data = array_merge($data, [
            UserClaimColumnsEnum::PICTURE_ID => $picture->id,
            UserClaimColumnsEnum::REASON_ID => $reason->id,
            UserClaimColumnsEnum::IP => DB::raw("inet_aton({$ip})"),
        ]);
        return UserClaimModel::factory()->create($data);
    }

    public function createSprClaimReason(): SprClaimReasonModel
    {
        return SprClaimReasonModel::factory()->create();
    }
}
