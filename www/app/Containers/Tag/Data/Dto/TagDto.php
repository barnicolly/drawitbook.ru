<?php

namespace App\Containers\Tag\Data\Dto;

use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Parents\Dto\Dto;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Collection;

class TagDto extends Dto
{

    public int $id;

    public string $name;

    public string $seo;

//    todo-misha к dto;
    public string $link;

    public string $link_title;

    public array $flags;

    public static function fromModel(SprTagsModel $model): self
    {
        $seoLang = $model->seo_lang;
        $link = app(RouteService::class)->getRouteArtsCellTagged($seoLang->current->slug);
        $tagName = mbUcfirst($seoLang->current->name);
        $prefix = __('common.pixel_arts');
        $linkTitle = "{$prefix} «{$tagName}»";
        return new static(
            id: $model->id,
            name: $seoLang->current->name,
            seo: $seoLang->current->slug,
            link: $link,
            link_title: $linkTitle,
            flags: self::formFlags($model->flags),
        );
    }

    private static function formFlags(Collection $flags): array
    {
//        todo-misha вынести имя колонки флага;
        return $flags->pluck('name')->toArray();
    }
}
