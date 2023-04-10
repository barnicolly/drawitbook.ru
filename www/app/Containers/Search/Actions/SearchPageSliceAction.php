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
    public function __construct(private readonly SearchPicturesAction $searchPicturesAction, private readonly CreateCellSliceResultsAction $createCellSliceResultsAction)
    {
    }

    /**
     * @return array{GetCellTaggedResultDto, PaginationDto}
     *
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
