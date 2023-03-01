<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Data\Factories\SprTagsModelFactory;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelFlags\Models\Concerns\HasFlags;
use Spatie\ModelFlags\Models\Flag;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $seo
 * @property string $slug_en
 *
 * @property Flag[] | Collection flags
 *
 * @method static SprTagsModelFactory factory()
 */
class SprTagsModel extends CoreModel
{
    use HasFactory;
    use HasFlags;

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
