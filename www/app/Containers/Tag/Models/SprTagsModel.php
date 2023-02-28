<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Data\Dto\TagSeoDto;
use App\Containers\Tag\Data\Dto\TagSeoLangDto;
use App\Containers\Tag\Data\Factories\SprTagsModelFactory;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
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
 * @property TagSeoLangDto $seo_lang
 * @property Flag[] | Collection flags
 *
 * @method static SprTagsModelFactory factory()
 */
class SprTagsModel extends CoreModel
{
    use HasFactory;
    use HasFlags;

    protected $table = SprTagsColumnsEnum::TABlE;

    protected $appends = ['seo_lang'];

    public function getSeoLangAttribute(): TagSeoLangDto
    {
        $locale = app()->getLocale();
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;

        if ($locale === LangEnum::RU) {
            $current = new TagSeoDto(locale: LangEnum::fromValue($locale), slug: $this->seo, name: $this->name);
            $alternative = new TagSeoDto(locale: LangEnum::fromValue($alternativeLang), slug: $this->slug_en, name: $this->name_en);
        } else {
            $current = new TagSeoDto(locale: LangEnum::fromValue($locale), slug: $this->slug_en, name: $this->name_en);
            $alternative = new TagSeoDto(locale: LangEnum::fromValue($alternativeLang), slug: $this->seo, name: $this->name);
        }


        return new TagSeoLangDto(current: $current, alternative: $alternative);
    }

    public $timestamps = false;

    protected $fillable = [
        SprTagsColumnsEnum::NAME,
    ];

    protected static function newFactory(): SprTagsModelFactory
    {
        return SprTagsModelFactory::new();
    }
}
