<?php

declare(strict_types=1);

namespace App\Containers\Menu\Models;

use App\Containers\Menu\Data\Factories\MenuLevelsModelFactory;
use App\Containers\Menu\Enums\MenuLevelsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $spr_tag_id
 * @property int $parent_level_id
 * @property string $custom_name_ru
 * @property string $custom_name_en
 * @property int $show_ru
 * @property int $show_en
 * @property int $column
 *
 * @method static MenuLevelsModelFactory factory
 */
final class MenuLevelsModel extends CoreModel
{
    use HasFactory;

    protected $table = MenuLevelsColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): MenuLevelsModelFactory
    {
        return MenuLevelsModelFactory::new();
    }
}
