<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Data\Factories\TagEntitiesModelFactory;
use App\Containers\Tag\Enums\TagEntitiesColumnsEnum;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $tag_id
 * @property int $entity_id
 * @property string $entity_type
 *
 * @method static TagEntitiesModelFactory factory()
 *
 * @property TagsModel $tag
 */
class TagEntitiesModel extends CoreModel
{
    use HasFactory;

    protected $table = TagEntitiesColumnsEnum::TABlE;

    protected $fillable = [];

    protected static function newFactory(): TagEntitiesModelFactory
    {
        return TagEntitiesModelFactory::new();
    }

    public function tag(): HasOne
    {
        return $this->hasOne(
            TagsModel::class,
            TagsColumnsEnum::ID,
            TagEntitiesColumnsEnum::TAG_ID,
        );
    }
}
