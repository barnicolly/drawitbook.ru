<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureModelFactory;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $description
 * @property int $is_del
 * @property int $in_common
 * @property int $in_vk_posting
 *
 * @method static PictureModelFactory factory()->create()
 */
//todo-misha убрать description, не используется;
class PictureModel extends CoreModel
{
    use HasFactory;

    protected $table = PictureColumnsEnum::TABlE;

    protected $fillable = [];

    public function extensions(): HasMany
    {
        return $this->hasMany(PictureExtensionsModel::class, 'picture_id', 'id');
    }

    protected static function newFactory(): PictureModelFactory
    {
        return PictureModelFactory::new();
    }
}
