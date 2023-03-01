<?php

namespace App\Containers\Picture\Actions\Cell;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\GetTagBySeoNameTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Parents\Actions\Action;
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
     * @param int $pageNum
     * @return array{GetCellTaggedResultDto, bool}
     * @throws NotFoundRelativeArts
     * @throws NotFoundTagException
     * @throws UnknownProperties
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function run(string $tag, int $pageNum): array
    {
        $locale = app()->getLocale();
        $tagInfo = $this->getTagBySeoNameTask->run($tag, $locale);
        if (!$tagInfo) {
            throw new NotFoundTagException();
        }
        $viewData = $this->getPaginatedCellArtsByTagTask->run($tagInfo->id, $pageNum);
        $isLastSlice = $viewData['isLastSlice'];
        if (!$isLastSlice) {
            $countLeftArtsText = $this->translationService->getPluralForm(
                $viewData['countLeftArts'],
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


