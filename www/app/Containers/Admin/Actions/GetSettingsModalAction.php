<?php

namespace App\Containers\Admin\Actions;

use App\Containers\Admin\Data\Dto\GetSettingsModalResultDto;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Containers\Vk\Tasks\VkAlbum\GetAllVkAlbumTask;
use App\Containers\Vk\Tasks\VkAlbumPicture\GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask;
use App\Ship\Parents\Actions\Action;

class GetSettingsModalAction extends Action
{

    private GetAllVkAlbumTask $getAllVkAlbumTask;
    private GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask $getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask;

    /**
     * @param GetAllVkAlbumTask $getAllVkAlbumTask
     * @param GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask $getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask
     */
    public function __construct(
        GetAllVkAlbumTask $getAllVkAlbumTask,
        GetVkAlbumPicturesByVkAlbumIdsAndPictureIdTask $getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask
    ) {
        $this->getAllVkAlbumTask = $getAllVkAlbumTask;
        $this->getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask = $getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask;
    }

    /**
     * @param int $pictureId
     * @return GetSettingsModalResultDto
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function run(int $pictureId): GetSettingsModalResultDto
    {
        $vkAlbums = $this->getAllVkAlbumTask->run();
        $vkAlbumIds = array_column($vkAlbums, 'id');
        $viewData['vkAlbums'] = $vkAlbums;
        $vkAlbumPictures = $this->getVkAlbumPicturesByVkAlbumIdsAndPictureIdTask->run($pictureId, $vkAlbumIds);
        $viewData['issetInVkAlbums'] = $vkAlbumPictures
            ->map(function (VkAlbumPictureModel $item) {
                return $item->vk_album_id;
            })
            ->unique()
            ->toArray();
        $modal = view('admin::art.modal', $viewData)->render();
        return new GetSettingsModalResultDto(html: $modal);
    }

}


