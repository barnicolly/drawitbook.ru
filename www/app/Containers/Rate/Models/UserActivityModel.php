<?php

namespace App\Containers\Rate\Models;

use App\Containers\Rate\Data\Factories\UserActivityModelFactory;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//todo-misha убрать status;
/**
 * @property int $id
 * @property int $ip
 * @property int $user_id
 * @property int $picture_id
 * @property int $activity
 * @property int $status
 *
 *  @method static UserActivityModelFactory factory()
 */
class UserActivityModel extends CoreModel
{
    use HasFactory;

    protected $table = UserActivityColumnsEnum::TABlE;

    public $timestamps = true;

    protected $fillable = [
        UserActivityColumnsEnum::ACTIVITY,
    ];

    protected static function newFactory(): UserActivityModelFactory
    {
        return UserActivityModelFactory::new();
    }
}
