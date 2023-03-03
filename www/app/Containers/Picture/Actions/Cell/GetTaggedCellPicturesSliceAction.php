<?php

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\GetTagBySeoNameTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PaginationDto;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class GetTaggedCellPicturesSliceAction extends Action
{

    private TranslationService $translationService;
    private GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask;
    private GetTagBySeoNameTask $getTagBySeoNameTask;

    /**
     * @param TranslationService $translationService
     * @param GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask
     * @param GetTagBySeoNameTask $getTagBySeoNameTask
     */
    public function __construct(
        TranslationService $translationService,
        GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask,
        GetTagBySeoNameTask $getTagBySeoNameTask
    ) {
        $this->translationService = $translationService;
        $this->getPaginatedCellArtsByTagTask = $getPaginatedCellArtsByTagTask;
        $this->getTagBySeoNameTask = $getTagBySeoNameTask;
    }

    /**
     * @param string $tag
     * @return array{GetCellTaggedResultDto, bool}
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
        $viewData['arts'] = $paginator->getCollection()->toArray();
        $paginationData = PaginationDto::createFromPaginator($paginator);
        $viewData['paginationData'] = $paginationData;
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
        return [$getCellTaggedResultDto, !$paginationData->hasMore];
    }

}


