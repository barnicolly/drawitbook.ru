<?php

namespace App\Containers\Picture\Http\Controllers\Cell;

use App\Containers\Picture\Actions\Cell\GetTaggedCellPicturesSliceAction;
use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Requests\Cell\CellTaggedArtsSliceAjaxRequest;
use App\Containers\Tag\Exceptions\NotFoundTagException;
use App\Ship\Parents\Controllers\AjaxController;
use App\Ship\Parents\Resources\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CellAjaxController extends AjaxController
{
    /**
     * @see \App\Containers\Picture\Tests\Feature\Http\Controllers\Cell\CellAjaxControllerTest
     */
    public function slice(
        string $tag,
        CellTaggedArtsSliceAjaxRequest $request,
        GetTaggedCellPicturesSliceAction $action,
    ): JsonResponse {
        try {
            [$getCellTaggedResultDto, $paginationMetaDto] = $action->run($tag);
            return JsonResource::make($getCellTaggedResultDto)
                ->withPaginationMeta($paginationMetaDto)
                ->response();
        } catch (NotFoundTagException|NotFoundRelativeArts $e) {
            throw new NotFoundHttpException();
        } catch (Throwable $e) {
            Log::error($e);
            abort(500);
        }
    }
}
