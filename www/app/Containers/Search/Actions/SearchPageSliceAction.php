<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SearchPageSliceAction extends Action
{
    private TranslationService $translationService;
    private SearchPicturesAction $searchPicturesAction;

    public function __construct(
        TranslationService $translationService,
        SearchPicturesAction $searchPicturesAction
    ) {
        $this->translationService = $translationService;
        $this->searchPicturesAction = $searchPicturesAction;
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

        $relativeArts = $paginator->getCollection()->toArray();

        $paginationData = PaginationDto::createFromPaginator($paginator);
        $viewData = [
            'arts' => $relativeArts,
        ];
        if ($paginationData->hasMore) {
            $countLeftArtsText = $this->translationService->getPluralForm(
                $paginationData->left,
                LangEnum::fromValue($locale)
            );
        }
        $getCellTaggedResultDto = new GetCellTaggedResultDto(
            html:              view('picture::template.stack_grid.elements', $viewData)->render(),
            countLeftArtsText: $countLeftArtsText ?? null,
        );
        return [$getCellTaggedResultDto, $paginationData];
    }

}


