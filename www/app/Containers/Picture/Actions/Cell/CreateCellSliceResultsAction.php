<?php

namespace App\Containers\Picture\Actions\Cell;

use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;

class CreateCellSliceResultsAction extends Action
{
    public function __construct(private readonly TranslationService $translationService)
    {
    }

    /**
     * @return array{GetCellTaggedResultDto, PaginationDto}
     *
     * @throws UnknownProperties
     */
    public function run(string $locale, LengthAwarePaginator $paginator): array
    {
        $relativeArts = $paginator->getCollection()->toArray();
        $paginationData = PaginationDto::createFromPaginator($paginator);
        $viewData = [
            'arts' => $relativeArts,
        ];
        if ($paginationData->hasMore) {
            $countLeftArtsText = $this->translationService->getPluralForm(
                $paginationData->left,
                LangEnum::fromValue($locale),
            );
        }
        $getCellTaggedResultDto = new GetCellTaggedResultDto(
            html: view('picture::template.stack_grid.elements', $viewData)->render(),
            countLeftArtsText: $countLeftArtsText ?? null,
        );
        return [$getCellTaggedResultDto, $paginationData];
    }
}
