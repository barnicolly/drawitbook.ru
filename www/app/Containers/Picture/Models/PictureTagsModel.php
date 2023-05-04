<?php

namespace App\Containers\Picture\Models;

use App\Containers\Picture\Data\Factories\PictureTagsModelFactory;
use App\Containers\Picture\Enums\PictureTagsColumnsEnum;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $picture_id
 * @property int $tag_id
 *
 * @method static PictureTagsModelFactory factory()
 *
 * @property TagsModel tag
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
            TagsModel::class,
            TagsColumnsEnum::ID,
            PictureTagsColumnsEnum::TAG_ID
        );
    }
}
