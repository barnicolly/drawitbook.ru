<?php

namespace App\Containers\Image\Models;

use App\Containers\Image\Data\Factories\ImagesModelFactory;
use App\Containers\Image\Enums\ImagesColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $path
 * @property int $width
 * @property int $height
 * @property string $ext
 * @property string $mime_type
 *
 * @method static ImagesModelFactory factory()
 */
class ImagesModel extends CoreModel
{
    use HasFactory;

    protected $table = ImagesColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): ImagesModelFactory
    {
        return ImagesModelFactory::new();
    }
}
