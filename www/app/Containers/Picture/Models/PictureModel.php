<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureModelFactory;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelFlags\Models\Concerns\HasFlags;

/**
 * @property int $id
 * @property int $in_common
 * @property int $in_vk_posting
 *
 * @method static PictureModelFactory factory
 */
//todo-misha перенести in_vk_posting в отдельную таблицу
class PictureModel extends CoreModel
{
    use HasFactory;
    use HasFlags;

    protected $table = PictureColumnsEnum::TABlE;

    protected $fillable = [
        PictureColumnsEnum::IN_VK_POSTING,
    ];

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
