<?php

namespace App\Containers\Picture\Models;

use App\Containers\Image\Enums\ImageEntitiesColumnsEnum;
use App\Containers\Image\Models\ImagesModel;
use App\Containers\Picture\Data\Factories\PictureModelFactory;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Tag\Enums\TagEntitiesColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\ModelFlags\Models\Concerns\HasFlags;
use Spatie\ModelFlags\Models\Flag;

/**
 * @property int $id
 *
 * @method static PictureModelFactory factory
 *
 * @property ImagesModel[] | Collection extensions
 * @property TagsModel[] | Collection tags
 * @property Flag[] | Collection flags
 */
class PictureModel extends CoreModel
{
    use HasFactory;
    use HasFlags;

    protected $table = PictureColumnsEnum::TABlE;

    public function extensions(): MorphToMany
    {
        return $this->morphToMany(
            ImagesModel::class,
            'entity',
            ImageEntitiesColumnsEnum::TABlE,
            null,
            ImageEntitiesColumnsEnum::IMAGE_ID,
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->morphToMany(
            TagsModel::class,
            'entity',
            TagEntitiesColumnsEnum::TABlE,
            null,
            TagEntitiesColumnsEnum::TAG_ID,
        );
    }

    protected static function newFactory(): PictureModelFactory
    {
        return PictureModelFactory::new();
    }
}
