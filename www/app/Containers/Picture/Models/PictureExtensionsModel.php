<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureExtensionsModelFactory;
use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $picture_id
 * @property string $path
 * @property int $width
 * @property int $height
 * @property string $ext
 * @property int $is_del
 *
 * @method static PictureExtensionsModelFactory factory()
 */

// todo-misha переименовать в pictureFiles
class PictureExtensionsModel extends CoreModel
{
    use HasFactory;

    protected $table = PictureExtensionsColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): PictureExtensionsModelFactory
    {
        return PictureExtensionsModelFactory::new();
    }
}
