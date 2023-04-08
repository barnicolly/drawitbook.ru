<?php

namespace App\Containers\Claim\Models;

use App\Containers\Claim\Data\Factories\UserClaimModelFactory;
use App\Containers\Claim\Enums\UserClaimColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property int|Expression $ip
 * @property int $picture_id
 * @property int $reason_id
 *
 * @method static UserClaimModelFactory factory()->create()
 */
class UserClaimModel extends CoreModel
{
    use HasFactory;

    protected $table = UserClaimColumnsEnum::TABlE;

    public $timestamps = false;
    protected $dates = ['created_at'];

    protected $fillable = [];

    protected static function newFactory(): UserClaimModelFactory
    {
        return UserClaimModelFactory::new();
    }
}
