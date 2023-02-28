<?php

namespace App\Containers\Picture\Data;

use App\Containers\Picture\Data\Dto\ArtDto;
use App\Containers\Picture\Data\Dto\PictureFileDto;
use App\Containers\Picture\Data\Dto\PictureFilesDto;
use App\Containers\Picture\Models\PictureExtensionsModel;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Models\SprTagsModel;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

use function App\Containers\Picture\Data\Dto\collect;

class PictureDtoBuilder extends Task
{
    private PictureModel $art;

    private ?string $alt;

    private ?PictureFilesDto $images;

    private ?array $flags;

    private ?array $tags;

    public function __construct(PictureModel $art)
    {
        $this->art = $art;
        $this->images = null;
        $this->alt = null;
        $this->flags = null;
        $this->tags = null;
    }

    /**
     * @param Collection<PictureExtensionsModel>|null $files
     * @return $this
     * @throws UnknownProperties
     */
    public function setFiles(?Collection $files): self
    {
        foreach ($files as $file) {
            $fileDto = new PictureFileDto(
                path: $file->path,
                fs_path: formArtFsPath($file->path),
                relative_path: getArtsFolder() . $file->path,
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
        $this->images = new PictureFilesDto(
            primary: $mainArt ?? null,
            optimized: $optimizedArt ?? null
        );
        return $this;
    }

    /**
     * @param Collection $flags
     * @return PictureDtoBuilder
     */
    public function setFlags(Collection $flags): self
    {
        $this->flags = $this->formFlags($flags);
        return $this;
    }

    public function build(): ArtDto
    {
        return new ArtDto(
            id: $this->art->id,
            alt: $this->alt,
            flags: $this->flags,
            images: $this->images,
            tags: $this->tags,
        );
    }

    /**
     * @param Collection<SprTagsModel> $artTags
     * @return PictureDtoBuilder
     */
    public function setTags(Collection $artTags): self
    {
        $this->tags = $artTags
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
        $this->alt = $this->setArtAltForDto($this->tags);
        return $this;
    }

    /**
     * @param array<TagDto> $tags
     * @return string
     */
    private function setArtAltForDto(array $tags): string
    {
        $result = __('common.pixel_arts');
        if (!empty($tags)) {
            $tags = collect($tags);
            $localizedTags = $tags
                ->map(fn(TagDto $dto) => $dto->name)
                ->toArray();
            $result .= " ➣ " . implode(' ➣ ', $localizedTags);
        }
        return $result;
    }

    /**
     * @param Collection $flags
     * @return array
     */
    private function formFlags(Collection $flags): array
    {
//        todo-misha вынести имя колонки флага;
        return $flags->pluck('name')->toArray();
    }

}


