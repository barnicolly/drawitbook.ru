<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Actions\Cell\CreateCellSliceResultsAction;
use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SearchPageSliceAction extends Action
{
    private SearchPicturesAction $searchPicturesAction;
    private CreateCellSliceResultsAction $createCellSliceResultsAction;

    public function __construct(
        SearchPicturesAction $searchPicturesAction,
        CreateCellSliceResultsAction $createCellResultsAction
    ) {
        $this->searchPicturesAction = $searchPicturesAction;
        $this->createCellSliceResultsAction = $createCellResultsAction;
    }

    /**
     * @param SearchDto $searchDto
     * @return array{GetCellTaggedResultDto, PaginationDto}
     * @throws NotFoundRelativeArts
     * @throws UnknownProperties
     */
    public function run(SearchDto $searchDto): array
    {
        $locale = app()->getLocale();
        $paginator = $this->searchPicturesAction->run($searchDto);
        return $this->createCellSliceResultsAction->run($locale, $paginator);
    }

}


