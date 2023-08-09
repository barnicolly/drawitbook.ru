<?php

declare(strict_types=1);

namespace App\Containers\Picture\Actions\Art;

use App\Containers\Picture\Data\Dto\ArtDto;
use App\Containers\Picture\Data\PictureDtoBuilder;
use App\Containers\Picture\Exceptions\NotFoundPicture;
use App\Containers\Picture\Tasks\Picture\GetPictureByIdTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class GetArtByIdWithFilesAction extends Action
{
    public function __construct(private readonly GetPictureByIdTask $getPictureByIdTask)
    {
    }

    /**
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
