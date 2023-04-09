<?php

namespace App\Containers\Admin\Actions;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Containers\Admin\Data\Dto\GetSettingsModalResultDto;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Containers\Vk\Tasks\VkAlbum\GetAllVkAlbumTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask;
use App\Ship\Parents\Actions\Action;

class GetSettingsModalAction extends Action
{

    public function __construct(private readonly GetAllVkAlbumTask $getAllVkAlbumTask, private readonly GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask $getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask)
    {
    }

    /**
     * @throws UnknownProperties
     */
    public function run(int $pictureId): GetSettingsModalResultDto
    {
        $viewData = [];
        $vkAlbums = $this->getAllVkAlbumTask->run();
        $vkAlbumIds = array_column($vkAlbums, 'id');
        $viewData['vkAlbums'] = $vkAlbums;
        $vkAlbumPictures = $this->getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask->run($pictureId, $vkAlbumIds);
        $viewData['issetInVkAlbums'] = $vkAlbumPictures
            ->map(fn(VkAlbumPictureModel $item): int => $item->vk_album_id)
            ->unique()
            ->toArray();
        $modal = view('admin::art.modal', $viewData)->render();
        return new GetSettingsModalResultDto(html: $modal);
    }

}


