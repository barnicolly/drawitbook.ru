<?php

namespace App\Containers\Claim\Service;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Containers\Claim\Models\UserClaimModel;
use Illuminate\Support\Facades\DB;

class ClaimService
{

    public function __construct()
    {
    }

    public function create(int $pictureId, string $ip, int $reasonId): bool
    {
        $claim = new UserClaimModel;
        $claim->picture_id = $pictureId;
        $claim->ip = DB::raw("inet_aton($ip)");
        $claim->reason_id = $reasonId;
        $claim->user_id = auth()->id();
        return $claim->save();
    }

    public function findByIpAndReasonId(int $pictureId, string $ip, int $reasonId): ?UserClaimModel
    {
        return UserClaimModel::where(UserClaimColumnsEnum::REASON_ID, $reasonId)
            ->whereRaw(UserClaimColumnsEnum::IP . " = inet_aton($ip)")
            ->where(UserClaimColumnsEnum::PICTURE_ID, '=', $pictureId)
            ->first();
    }

}


