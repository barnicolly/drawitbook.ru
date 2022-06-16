<?php

namespace App\Containers\Picture\Http\Controllers\Cell;

use App\Containers\Picture\Actions\Cell\GetTaggedCellPicturesSliceAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Requests\Cell\CellTaggedArtsSliceAjaxRequest;
use App\Containers\Picture\Http\Transformers\Cell\GetCellTaggedArtsSliceTransformer;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Ship\Dto\PaginationMetaDto;
use App\Ship\Parents\Controllers\AjaxController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CellAjaxController extends AjaxController
{

    /**
     * @param string $tag
     * @param CellTaggedArtsSliceAjaxRequest $request
     * @param GetTaggedCellPicturesSliceAction $action
     * @return JsonResponse
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Cell\CellAjaxControllerTest
     */
    public function slice(
        string $tag,
        CellTaggedArtsSliceAjaxRequest $request,
        GetTaggedCellPicturesSliceAction $action
    ): JsonResponse {
        try {
            $pageNum = $request->page;
            [$getCellTaggedResultDto, $isLastSlice] = $action->run($tag, $pageNum);
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
            Log::error($e->getMessage());
            abort(500);
        }
    }

}
