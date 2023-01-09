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
 *
 * @method static PictureModelFactory factory
 */
class PictureModel extends CoreModel
{
    use HasFactory;
    use HasFlags;

    protected $table = PictureColumnsEnum::TABlE;

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
