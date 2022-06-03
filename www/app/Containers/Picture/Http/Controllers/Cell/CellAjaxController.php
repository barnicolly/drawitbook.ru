<?php

namespace App\Containers\Picture\Http\Controllers\Cell;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Http\Requests\Cell\CellTaggedArtsSliceAjaxRequest;
use App\Containers\Picture\Http\Transformers\Cell\GetCellTaggedArtsSliceTransformer;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PaginationMetaDto;
use App\Ship\Parents\Controllers\AjaxController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CellAjaxController extends AjaxController
{

    private TagsService $tagsService;
    private TranslationService $translationService;

    public function __construct(
        TranslationService $translationService,
        TagsService $tagsService
    ) {
        $this->tagsService = $tagsService;
        $this->translationService = $translationService;
    }

    public function slice(
        string $tag,
        CellTaggedArtsSliceAjaxRequest $request,
        GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask
    ): JsonResponse {
        $pageNum = (int) $request->input('page');
        try {
            $locale = app()->getLocale();
            $tagInfo = $this->tagsService->getByTagSeoName($tag, $locale);
            if (!$tagInfo) {
                throw new NotFoundTagException();
            }
            $viewData = $getPaginatedCellArtsByTagTask->run($tagInfo['id'], $pageNum);
            $isLastSlice = $viewData['isLastSlice'];
            if (!$isLastSlice) {
                $countLeftArtsText = $this->translationService->getPluralForm(
                    $viewData['countLeftArts'],
                    LangEnum::fromValue($locale)
                );
            }
            $getCellTaggedResultDto = new GetCellTaggedResultDto([
                'html' => view('picture::template.stack_grid.elements', $viewData)->render(),
                'countLeftArtsText' => $countLeftArtsText ?? null,
            ]);
            $paginationMetaDto = new PaginationMetaDto(
                [
                    'page' => $pageNum,
                    'isLastPage' => $isLastSlice,
                ]
            );
            $result = fractal()->item($getCellTaggedResultDto, new GetCellTaggedArtsSliceTransformer())
                ->addMeta(['pagination' => $paginationMetaDto]);
            return response()->json($result);
        } catch (NotFoundTagException $e) {
            throw new NotFoundHttpException();
        } catch (UnknownProperties $e) {
            abort(500);
        }
    }

}
