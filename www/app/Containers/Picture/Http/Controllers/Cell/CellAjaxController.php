<?php

namespace App\Containers\Picture\Http\Controllers\Cell;

use App\Containers\Picture\Data\Dto\GetCellTaggedResultDto;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Requests\Cell\CellTaggedArtsSliceAjaxRequest;
use App\Containers\Picture\Http\Transformers\Cell\GetCellTaggedArtsSliceTransformer;
use App\Containers\Picture\Tasks\Picture\Cell\GetPaginatedCellArtsByTagTask;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Containers\Tag\Tasks\GetTagBySeoNameTask;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Dto\PaginationMetaDto;
use App\Ship\Parents\Controllers\AjaxController;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CellAjaxController extends AjaxController
{

    private TranslationService $translationService;

    public function __construct(
        TranslationService $translationService,
    ) {
        $this->translationService = $translationService;
    }

    /**
     * @param string $tag
     * @param CellTaggedArtsSliceAjaxRequest $request
     * @param GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask
     * @param GetTagBySeoNameTask $getTagBySeoNameTask
     * @return JsonResponse
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Cell\CellAjaxControllerTest
     */
    public function slice(
        string $tag,
        CellTaggedArtsSliceAjaxRequest $request,
        GetPaginatedCellArtsByTagTask $getPaginatedCellArtsByTagTask,
        GetTagBySeoNameTask $getTagBySeoNameTask
    ): JsonResponse {
        $pageNum = (int) $request->input('page');
        try {
            $locale = app()->getLocale();
            $tagInfo = $getTagBySeoNameTask->run($tag, $locale);
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
        } catch (NotFoundTagException|NotFoundRelativeArts $e) {
            throw new NotFoundHttpException();
        } catch (Throwable $e) {
            abort(500);
        }
    }

}
