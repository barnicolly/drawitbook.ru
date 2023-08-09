<?php

declare(strict_types=1);

namespace App\Containers\Tag\Data\Dto;

use App\Containers\Tag\Models\TagsModel;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Dto\Dto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagSeoLangDto extends Dto
{
    public TagSeoDto $current;

    public TagSeoDto $alternative;

    /**
     * @throws UnknownProperties
     */
    public static function fromModel(TagsModel $model, string $locale): self
    {
        $alternativeLang = $locale === LangEnum::RU ? LangEnum::EN : LangEnum::RU;

        if ($locale === LangEnum::RU) {
            $current = new TagSeoDto(locale: LangEnum::fromValue($locale), slug: $model->seo, name: $model->name);
            $alternative = new TagSeoDto(
                locale: LangEnum::fromValue($alternativeLang),
                slug: $model->slug_en,
                name: $model->name_en
            );
        } else {
            $current = new TagSeoDto(
                locale: LangEnum::fromValue($locale),
                slug: $model->slug_en,
                name: $model->name_en
            );
            $alternative = new TagSeoDto(
                locale: LangEnum::fromValue($alternativeLang),
                slug: $model->seo,
                name: $model->name
            );
        }
        return new self(current: $current, alternative: $alternative);
    }
}
