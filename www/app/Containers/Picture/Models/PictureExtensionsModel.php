<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Enums\PictureExtensionsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $picture_id
 * @property string $path
 * @property int $width
 * @property int $height
 * @property string $ext
 * @property int $is_del
 */
class PictureExtensionsModel extends CoreModel
{
    protected $table = PictureExtensionsColumnsEnum::TABlE;

    protected $fillable = [];

}
