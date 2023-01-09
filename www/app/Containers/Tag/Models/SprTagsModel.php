<?php

namespace App\Containers\Tag\Models;

use App\Containers\Tag\Data\Dto\TagSeoDto;
use App\Containers\Tag\Data\Dto\TagSeoLangDto;
use App\Containers\Tag\Data\Factories\SprTagsModelFactory;
use App\Containers\Tag\Enums\SprTagsColumnsEnum;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelFlags\Models\Concerns\HasFlags;

/**
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $hidden
 * @property int $hidden_vk
 * @property string $seo
 * @property string $slug_en
 * @property string $is_popular
 *
 * @property TagSeoLangDto $seo_lang
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

        $current = $this->createTagSeoDto($locale);
        $alternative = $this->createTagSeoDto($alternativeLang);

        return new TagSeoLangDto(current: $current, alternative: $alternative);
    }

    private function createTagSeoDto(string $locale): TagSeoDto
    {
        $name = $locale === LangEnum::RU ? $this->name: $this->name_en;
        $slug = $locale === LangEnum::RU ? $this->seo: $this->slug_en;
        return new TagSeoDto(locale: LangEnum::fromValue($locale), slug: $slug, name: $name);
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
