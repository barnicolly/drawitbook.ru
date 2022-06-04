<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $hidden
 * @property int $hidden_vk
 * @property string $seo
 * @property string $slug_en
 * @property string $is_popular
 */
class SprTagsModel extends CoreModel
{
    protected $table = SprTagsColumnsEnum::TABlE;

    public $timestamps = false;

    protected $fillable = [
        SprTagsColumnsEnum::NAME,
    ];
}
