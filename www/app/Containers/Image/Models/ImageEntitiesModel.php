<?php

namespace App\Containers\Image\Models;

use App\Containers\Image\Data\Factories\ImageEntitiesModelFactory;
use App\Containers\Image\Enums\ImageEntitiesColumnsEnum;
use App\Containers\Image\Enums\ImagesColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $image_id
 * @property int $entity_id
 * @property string $entity_type
 * @property ImagesModel | null $image
 *
 * @method static ImageEntitiesModelFactory factory()
 */
class ImageEntitiesModel extends CoreModel
{
    use HasFactory;

    protected $table = ImageEntitiesColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): ImageEntitiesModelFactory
    {
        return ImageEntitiesModelFactory::new();
    }

    public function image(): HasOne
    {
        return $this->hasOne(
            ImagesModel::class,
            ImagesColumnsEnum::ID,
            ImageEntitiesColumnsEnum::IMAGE_ID,
        );
    }
}
