<?php

namespace App\Containers\Rate\Models;

use App\Containers\Rate\Data\Factories\LikesModelFactory;
use App\Containers\Rate\Enums\LikesColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $ip
 * @property int $user_id
 * @property int $picture_id
 * @property int $activity
 *
 * @method static LikesModelFactory factory()
 */
class LikesModel extends CoreModel
{
    use HasFactory;

    protected $table = LikesColumnsEnum::TABlE;

    public $timestamps = true;

    protected $fillable = [];

    protected static function newFactory(): LikesModelFactory
    {
        return LikesModelFactory::new();
    }
}
