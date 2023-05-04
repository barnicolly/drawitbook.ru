<?php

namespace App\Containers\Image\Models;

use App\Containers\Image\Data\Factories\ImageEntitiesModelFactory;
use App\Containers\Image\Enums\ImageEntitiesColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $image_id
 * @property int $entity_id
 * @property string $entity_type
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
}
