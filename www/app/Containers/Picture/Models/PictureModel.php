<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureModelFactory;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $in_common
 * @property int $in_vk_posting
 *
 * @method static PictureModelFactory factory()->create()
 */
//todo-misha перенести in_vk_posting в отдельную таблицу
class PictureModel extends CoreModel
{
    use HasFactory;

    protected $table = PictureColumnsEnum::TABlE;

    protected $fillable = [];

    public function extensions(): HasMany
    {
        return $this->hasMany(
            PictureExtensionsModel::class,
            PictureExtensionsColumnsEnum::PICTURE_ID,
            PictureColumnsEnum::ID
        );
    }

    protected static function newFactory(): PictureModelFactory
    {
        return PictureModelFactory::new();
    }
}
