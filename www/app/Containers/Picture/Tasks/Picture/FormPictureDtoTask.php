<?php

namespace App\Containers\Picture\Tasks\Picture;

use App\Containers\Picture\Data\Dto\ArtDto;
use App\Containers\Picture\Data\Dto\PictureFileDto;
use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Collection;

class FormPictureDtoTask extends Task
{

    private SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function run(Collection $arts): array
    {
        return $arts
            ->map(function (PictureModel $picture) {
                return (new ArtDto(
                    id: $picture->id,
                    alt: $this->seoService->setArtAltForDto($picture->tags),
                    flags: $this->formFlags($picture->flags),
                    images: $this->formImages($picture->extensions),
                    tags: $this->formTags($picture->tags),
                ))
                    ->toArray();
            })
            ->toArray();
    }

    private function formFlags(Collection $flags): array
    {
//        todo-misha вынести имя колонки флага;
        return $flags->pluck('name')->toArray();
    }

    /**
     * @param Collection<SprTagsModel> $artTags
     * @return array
     */
    private function formTags(Collection $artTags): array
    {
        return $artTags
            ->map(function (SprTagsModel $artTag) {
                $seoLang = $artTag->seo_lang;
                $link = app(RouteService::class)->getRouteArtsCellTagged($seoLang->current->slug);
                $tagName = mbUcfirst($seoLang->current->name);
                $prefix = __('common.pixel_arts');
                $linkTitle = "{$prefix} «{$tagName}»";
                return new TagDto(
                    id: $artTag->id,
                    name: $seoLang->current->name,
                    seo: $seoLang->current->slug,
                    link: $link,
                    link_title: $linkTitle,
                    flags: $this->formFlags($artTag->flags),
                );
            })
            ->toArray();
    }

    /**
     * @param Collection<PictureExtensionsModel> $artFiles
     * @return PictureFileDto[]|null[]
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function formImages(Collection $artFiles): array
    {
        foreach ($artFiles as $file) {
            $fileDto = new PictureFileDto(
                path: $file->path,
                fs_path: formArtFsPath($file->path),
                height: $file->id,
                width: $file->id,
                mime_type: $file->mime_type,
            );
            if ($file->ext === 'webp') {
                $optimizedArt = $fileDto;
            } else {
                $mainArt = $fileDto;
            }
        }
        return [
            'primary' => $mainArt ?? null,
            'optimized' => $optimizedArt ?? null,
        ];
    }
}


