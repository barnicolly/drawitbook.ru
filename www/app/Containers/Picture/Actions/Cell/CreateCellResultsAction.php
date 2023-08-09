<?php

declare(strict_types=1);

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;

final class CreateCellResultsAction extends Action
{
    public function __construct(private readonly TranslationService $translationService)
    {
    }

    /**
     * @return array{arts: mixed[], paginationData: PaginationDto, leftArtsText: (string | null)}
     */
    public function run(string $locale, LengthAwarePaginator $paginator): array
    {
        $viewData = [];
        $paginationData = PaginationDto::createFromPaginator($paginator);

        $relativeArts = $paginator->getCollection()->toArray();

        $viewData['arts'] = $relativeArts;
        $viewData['paginationData'] = $paginationData;

        $viewData['leftArtsText'] = $paginator->hasMorePages()
            ? $this->translationService->getPluralForm($paginationData->left, LangEnum::fromValue($locale))
            : null;
        return $viewData;
    }
}
