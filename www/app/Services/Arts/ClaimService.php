<?php

namespace App\Services\Arts;

use App\Entities\User\UserClaimModel;
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
        return UserClaimModel::where('reason_id', $reasonId)
            ->whereRaw("ip = inet_aton($ip)")
            ->where('picture_id', '=', $pictureId)
            ->first();
    }

}


