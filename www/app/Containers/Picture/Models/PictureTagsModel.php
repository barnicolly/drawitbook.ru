<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureTagsModelFactory;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $picture_id
 * @property int $tag_id
 *
 * @method static PictureTagsModelFactory factory()
 */
class PictureTagsModel extends CoreModel
{
    use HasFactory;

    protected $table = PictureTagsColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): PictureTagsModelFactory
    {
        return PictureTagsModelFactory::new();
    }
}
