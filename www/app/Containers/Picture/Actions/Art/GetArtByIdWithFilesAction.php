<?php

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Data\Dto\ArtDto;
use App\Containers\Picture\Data\PictureDtoBuilder;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Tasks\Picture\GetPictureByIdTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetArtByIdWithFilesAction extends Action
{

    private GetPictureByIdTask $getPictureByIdTask;

    public function __construct(GetPictureByIdTask $getPictureByIdTask)
    {
        $this->getPictureByIdTask = $getPictureByIdTask;
    }

    /**
     * @param int $id
     * @return ArtDto
     * @throws NotFoundPicture
     * @throws RepositoryException
     * @throws UnknownProperties
     */
    public function run(int $id): ArtDto
    {
        $art = $this->getPictureByIdTask->run($id);
        if (!$art) {
            throw new NotFoundPicture();
        }
        $art->load(['extensions']);
        return (new PictureDtoBuilder($art))
            ->setFiles($art->extensions)
            ->build();
    }

}


