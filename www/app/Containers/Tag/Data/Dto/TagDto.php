<?php

declare(strict_types=1);

namespace App\Containers\Tag\Data\Dto;

use App\Containers\Tag\Models\TagsModel;
use App\Ship\Parents\Dto\Dto;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Collection;

final class TagDto extends Dto
{
    public int $id;

    public string $name;

    public string $seo;

    //    todo-misha к dto;
    public string $link;

    public string $link_title;

    public array $flags;

    public TagSeoLangDto $seo_lang;

    public static function fromModel(TagsModel $model, string $locale = null): self
    {
        $locale ??= app()->getLocale();
        $seoLang = TagSeoLangDto::fromModel($model, $locale);
        $link = $seoLang->current->slug
            ? app(RouteService::class)->getRouteArtsCellTagged($seoLang->current->slug)
            : null;
        $tagName = $seoLang->current->name
            ? mbUcfirst($seoLang->current->name)
            : null;
        if ($tagName) {
            $prefix = __('common.pixel_arts');
            $linkTitle = "{$prefix} «{$tagName}»";
        }
        $flags = $model->relationLoaded('flags')
            ? self::formFlags($model->flags)
            : [];
        return new self(
            id: $model->id,
            name: $seoLang->current->name,
            seo: $seoLang->current->slug,
            link: $link,
            link_title: $linkTitle ?? null,
            flags: $flags,
            seo_lang: $seoLang,
        );
    }

    private static function formFlags(Collection $flags): array
    {
        //        todo-misha вынести имя колонки флага;
        return $flags->pluck('name')->toArray();
    }
}
