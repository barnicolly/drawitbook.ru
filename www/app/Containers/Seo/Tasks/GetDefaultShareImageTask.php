<?php

namespace App\Containers\Seo\Tasks;

use App\Containers\Picture\Actions\Art\GetArtByIdWithFilesAction;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Seo\Data\Dto\ShareImageDto;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Cache;

class GetDefaultShareImageTask extends Task
{
    private GetArtByIdWithFilesAction $getArtByIdWithFilesAction;

    public function __construct(GetArtByIdWithFilesAction $getArtByIdWithFilesAction)
    {
        $this->getArtByIdWithFilesAction = $getArtByIdWithFilesAction;
    }

    /**
     * @return ShareImageDto|null
     */
    public function run(): ?ShareImageDto
    {
        $cacheName = 'seo.default_share_image';
        $result = Cache::get($cacheName);
        if (!$result) {
            $result = Cache::remember(
                $cacheName,
                config('cache.expiration'),
                function () {
                    try {
                        $picture = $this->getArtByIdWithFilesAction->run(205);
                        return new ShareImageDto(
                            relativePath: $picture->images->primary->relative_path,
                            width:        $picture->images->primary->width,
                            height:       $picture->images->primary->height
                        );
                    } catch (NotFoundPicture $e) {
                        return null;
                    }
                }
            );
        }
        return $result;
    }
}


