<?php

namespace App\Containers\Category\Models;

use App\Containers\Category\Data\Factories\CategoryModelFactory;
use App\Containers\Category\Enums\CategoryColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property int $id
 * @property int $parent_id
 * @property int $spr_tag_id
 * @property string $custom_name_ru
 * @property string $custom_name_en
 * @property int $show_ru
 * @property int $show_en
 *
 * @method static CategoryModelFactory factory
 */
class CategoryModel extends CoreModel
{
    use HasFactory;

    protected $table = CategoryColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): CategoryModelFactory
    {
        return CategoryModelFactory::new();
    }
}
