<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property int $picture_id
 * @property int $tag_id
 */
class PictureTagsModel extends CoreModel
{
    protected $table = PictureTagsColumnsEnum::TABlE;

    protected $fillable = [];
}
