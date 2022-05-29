<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property string $description
 * @property int $is_del
 * @property int $in_common
 * @property int $in_vk_posting
 */
class PictureModel extends CoreModel
{
    protected $table = PictureColumnsEnum::TABlE;

    protected $fillable = [];

}
