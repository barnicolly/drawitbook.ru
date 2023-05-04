<?php

namespace App\Containers\Tag\Models;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Data\Factories\TagsModelFactory;
use App\Containers\Tag\Enums\TagEntitiesColumnsEnum;
use App\Containers\Tag\Enums\TagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\ModelFlags\Models\Concerns\HasFlags;
use Spatie\ModelFlags\Models\Flag;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $seo
 * @property string $slug_en
 * @property Flag[] | Collection flags
 *
 * @method static TagsModelFactory factory()
 */
class TagsModel extends CoreModel
{
    use HasFactory;
    use HasFlags;

    protected $table = TagsColumnsEnum::TABlE;

    public $timestamps = false;

    protected $fillable = [
        TagsColumnsEnum::NAME,
    ];

    protected static function newFactory(): TagsModelFactory
    {
        return TagsModelFactory::new();
    }

    public function pictures(): MorphToMany
    {
        return $this->morphedByMany(
            PictureModel::class,
            'entity',
            TagEntitiesColumnsEnum::TABlE,
            TagEntitiesColumnsEnum::TAG_ID,
            TagEntitiesColumnsEnum::ENTITY_ID,
        );
    }

}
