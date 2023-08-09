<?php

declare(strict_types=1);

namespace App\Containers\Seo\Tasks;

use App\Containers\Picture\Actions\Art\GetArtByIdWithFilesAction;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Seo\Data\Dto\ShareImageDto;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Cache;

final class GetDefaultShareImageTask extends Task
{
    /**
     * @var string
     */
    private const CACHE_NAME = 'seo.default_share_image';

    public function __construct(private readonly GetArtByIdWithFilesAction $getArtByIdWithFilesAction)
    {
    }

    public function run(): ?ShareImageDto
    {
        $result = Cache::get(self::CACHE_NAME);
        if (!$result) {
            $result = Cache::remember(
                self::CACHE_NAME,
                config('cache.expiration'),
                function (): ?ShareImageDto {
                    try {
                        $picture = $this->getArtByIdWithFilesAction->run(205);
                        return new ShareImageDto(
                            relativePath: $picture->images->primary->relative_path,
                            width: $picture->images->primary->width,
                            height: $picture->images->primary->height
                        );
                    } catch (NotFoundPicture) {
                        return null;
                    }
                },
            );
        }
        return $result;
    }
}
