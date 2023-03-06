<?php

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\GetTagBySeoNameTask;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetTaggedCellPicturesSliceAction extends Action
{

    private GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask;
    private GetTagBySeoNameTask $getTagBySeoNameTask;
    private CreateCellSliceResultsAction $createCellSliceResultsAction;

    public function __construct(
        GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask,
        GetTagBySeoNameTask $getTagBySeoNameTask,
        CreateCellSliceResultsAction $createCellResultsAction
    ) {
        $this->getPaginatedCellArtsByTagTask = $getPaginatedCellArtsByTagTask;
        $this->getTagBySeoNameTask = $getTagBySeoNameTask;
        $this->createCellSliceResultsAction = $createCellResultsAction;
    }

    /**
     * @param string $tag
     * @return array{GetCellTaggedResultDto, PaginationDto}
     * @throws NotFoundRelativeArts
     * @throws NotFoundTagException
     * @throws UnknownProperties
     * @throws RepositoryException
     */
    public function run(string $tag): array
    {
        $locale = app()->getLocale();
        $tagInfo = $this->getTagBySeoNameTask->run($tag, $locale);
        if (!$tagInfo) {
            throw new NotFoundTagException();
        }
        $paginator = $this->getPaginatedCellArtsByTagTask->run($tagInfo->id);
        return $this->createCellSliceResultsAction->run($locale, $paginator);
    }

}


