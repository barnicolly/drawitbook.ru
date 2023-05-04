<?php

namespace App\Containers\Picture\Data;

use App\Containers\Image\Models\ImagesModel;
use App\Containers\Picture\Data\Dto\ArtDto;
use App\Containers\Picture\Data\Dto\PictureFileDto;
use App\Containers\Picture\Data\Dto\PictureFilesDto;
use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Data\Dto\TagDto;
use App\Containers\Tag\Models\TagsModel;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PictureDtoBuilder extends Task
{
    private ?string $alt = null;

    private ?PictureFilesDto $images = null;

    private ?array $flags = null;

    private ?array $tags = null;

    public function __construct(private readonly PictureModel $art)
    {
    }

    /**
     * @param Collection<ImagesModel>|null $files
     *
     * @return $this
     *
     * @throws UnknownProperties
     */
    public function setFiles(?Collection $files): self
    {
        foreach ($files as $file) {
            $fileDto = PictureFileDto::fromModel($file);
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
     * @param Collection<TagsModel> $artTags
     */
    public function setTags(Collection $artTags): self
    {
        $this->tags = $artTags
            ->map(static fn (TagsModel $tag): TagDto => TagDto::fromModel($tag))
            ->toArray();
        $this->alt = $this->setArtAltForDto($this->tags);
        return $this;
    }

    /**
     * @param array<TagDto> $tags
     */
    private function setArtAltForDto(array $tags): string
    {
        $result = __('common.pixel_arts');
        if (!empty($tags)) {
            $tags = collect($tags);
            $localizedTags = $tags
                ->map(static fn (TagDto $dto): string => $dto->name)
                ->toArray();
            $result .= ' ➣ ' . implode(' ➣ ', $localizedTags);
        }
        return $result;
    }

    private function formFlags(Collection $flags): array
    {
        //        todo-misha вынести имя колонки флага;
        return $flags->pluck('name')->toArray();
    }
}
