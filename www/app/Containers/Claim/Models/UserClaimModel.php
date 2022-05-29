<?php

namespace App\Containers\Claim\Models;

use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Models\CoreModel;

/**
 * @property int $id
 * @property int $user_id
 * @property int $ip
 * @property int $picture_id
 * @property int $reason_id
 */
class UserClaimModel extends CoreModel
{
    protected $table = UserClaimColumnsEnum::TABlE;

    public $timestamps = false;
    protected $dates = ['created_at'];

    protected $fillable = [];
}
