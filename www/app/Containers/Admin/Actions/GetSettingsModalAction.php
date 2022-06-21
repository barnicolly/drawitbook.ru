<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Admin\Data\Dto\GetSettingsModalResultDto;
use App\Containers\Vk\Services\AlbumService;
use App\Ship\Parents\Actions\Action;

class GetSettingsModalAction extends Action
{

    private AlbumService $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    /**
     * @param int $pictureId
     * @return GetSettingsModalResultDto
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function run(int $pictureId): GetSettingsModalResultDto
    {
        $vkAlbums = $this->albumService->getVkAlbums();
        $vkAlbumIds = array_column($vkAlbums, 'id');
        $viewData['vkAlbums'] = $vkAlbums;
        $vkAlbumPictures = $this->albumService->getAlbumVkPictures($pictureId, $vkAlbumIds);
        $viewData['issetInVkAlbums'] = $this->albumService->extractVkAlbumIds($vkAlbumPictures);
        $modal = view('admin::art.modal', $viewData)->render();
        return new GetSettingsModalResultDto(html: $modal);
    }

}


