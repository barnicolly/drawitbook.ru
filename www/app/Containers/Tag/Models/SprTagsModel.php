<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Data\Factories\SprTagsModelFactory;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $hidden
 * @property int $hidden_vk
 * @property string $seo
 * @property string $slug_en
 * @property string $is_popular
 *
 * @method static SprTagsModelFactory factory()
 */
class SprTagsModel extends CoreModel
{
//    todo-misha сразу создать 2 поля alternative и current_lang;
    use HasFactory;

    protected $table = SprTagsColumnsEnum::TABlE;

    public $timestamps = false;

    protected $fillable = [
        SprTagsColumnsEnum::NAME,
    ];

    protected static function newFactory(): SprTagsModelFactory
    {
        return SprTagsModelFactory::new();
    }
}
