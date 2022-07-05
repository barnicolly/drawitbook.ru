<?php

namespace App\Containers\Search\Http\Controllers;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Transformers\Cell\GetCellTaggedArtsSliceTransformer;
use App\Containers\Search\Actions\SearchPageAction;
use App\Containers\Search\Actions\SearchPageSliceAction;
use App\Containers\Search\Http\Requests\SearchArtsSliceAjaxRequest;
use App\Ship\Dto\PaginationMetaDto;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class SearchController extends HttpController
{

    /**
     * @param Request $request
     * @param SearchPageAction $action
     * @return Response
     *
     * @see \App\Containers\Search\Tests\Feature\Http\Controllers\ShowSearchIndexPageTest
     */
    public function index(Request $request, SearchPageAction $action): Response
    {
        try {
//            todo-misha обработать данные в request и положить в dto;
            [$viewData, $pageMetaDto] = $action->run($request->input());
            $this->setMeta($pageMetaDto->title)
                ->setRobots('noindex, follow');
            return response()->view('search::index', $viewData);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param SearchArtsSliceAjaxRequest $request
     * @param SearchPageSliceAction $action
     * @return JsonResponse
     *
     * @see \App\Containers\Search\Tests\Feature\Http\Controllers\GetSearchPageSliceTest
     */
    public function slice(SearchArtsSliceAjaxRequest $request, SearchPageSliceAction $action): JsonResponse
    {
        //            todo-misha обработать данные в request и положить в dto;
        //TODO-misha вынести и объединить с кодом из cell;
        try {
            $pageNum = $request->page;
            [$getCellTaggedResultDto, $isLastSlice] = $action->run($pageNum, $request->input());
            $paginationMetaDto = new PaginationMetaDto(
                [
                    'page' => $pageNum,
                    'isLastPage' => $isLastSlice,
                ]
            );
            $result = fractal()->item($getCellTaggedResultDto, new GetCellTaggedArtsSliceTransformer())
                ->addMeta(['pagination' => $paginationMetaDto]);
            return response()->json($result);
        } catch (NotFoundRelativeArts $e) {
            throw new NotFoundHttpException();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

}

