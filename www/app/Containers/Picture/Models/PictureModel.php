<?php

declare(strict_types=1);

namespace App\Containers\Picture\Models;

use App\Containers\Image\Enums\ImageEntitiesColumnsEnum;
use App\Containers\Image\Models\ImagesModel;
use App\Containers\Picture\Data\Factories\PictureModelFactory;
use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Tag\Enums\TagEntitiesColumnsEnum;
use App\Containers\Tag\Models\TagsModel;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Models\CoreModel;
use Barnicolly\ModelSearch\Contracts\SearchContract;
use Barnicolly\ModelSearch\Traits\Searchable;
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
final class PictureModel extends CoreModel implements SearchContract
{
    use HasFactory;
    use HasFlags;
    use Searchable;

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

    public function toSearchArray(): array
    {
        $tags = [];
        $this->tags->load('flags');
        /** @var TagsModel $tag */
        foreach ($this->tags as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name,
                'name_en' => $tag->name_en,
                'rating' => $tag->hasFlag(FlagsEnum::TAG_HIDDEN) ? 3 : 8,
            ];
        }
        return ['tags' => $tags];
    }
}
