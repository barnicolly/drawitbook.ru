<?php

namespace App\Containers\Rate\Models;

use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $ip
 * @property int $user_id
 * @property int $picture_id
 * @property int $activity
 * @property int $status
 * @property int $is_del
 */
class UserActivityModel extends CoreModel
{
    protected $table = UserActivityColumnsEnum::TABlE;

    public $timestamps = true;

    protected $fillable = [
        UserActivityColumnsEnum::ACTIVITY,
    ];

}
