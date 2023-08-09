<?php

declare(strict_types=1);

namespace App\Containers\Like\Models;

use App\Containers\Like\Data\Factories\LikesModelFactory;
use App\Containers\Like\Enums\LikesColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int|Expression $ip
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
