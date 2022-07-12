<?php

namespace App\Containers\Search\Actions;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
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
     * @param int $pageNum
     * @param SearchDto $searchDto
     * @return array{GetCellTaggedResultDto, bool}
     * @throws NotFoundRelativeArts
     * @throws UnknownProperties
     */
    public function run(int $pageNum, SearchDto $searchDto): array
    {
        $locale = app()->getLocale();
        [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts] = $this->searchPicturesAction->run(
            $searchDto,
            $pageNum
        );
        if (!$relativeArts) {
            throw new NotFoundRelativeArts();
        }
        $viewData = [
            'page' => $pageNum,
            'isLastSlice' => $isLastSlice,
            'countLeftArts' => $countLeftArts,
            'arts' => $relativeArts,
            'countRelatedArts' => $countSearchResults,
        ];
        if (!$isLastSlice) {
            $countLeftArtsText = $this->translationService->getPluralForm(
                $countLeftArts,
                LangEnum::fromValue($locale)
            );
        }
        $getCellTaggedResultDto = new GetCellTaggedResultDto(
            html:              view('picture::template.stack_grid.elements', $viewData)->render(),
            countLeftArtsText: $countLeftArtsText ?? null,
        );
        return [$getCellTaggedResultDto, $isLastSlice];
    }

}


