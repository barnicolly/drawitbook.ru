<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureTagsModelFactory;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $picture_id
 * @property int $tag_id
 *
 * @method static PictureTagsModelFactory factory()
 * @property SprTagsModel tag
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

    public function tag(): HasOne
    {
        return $this->hasOne(
            SprTagsModel::class,
            SprTagsColumnsEnum::ID,
            PictureTagsColumnsEnum::TAG_ID
        );
    }
}
