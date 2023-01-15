<?php

namespace App\Containers\Search\Http\Controllers;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Http\Transformers\Cell\GetCellTaggedArtsSliceTransformer;
use App\Containers\Search\Actions\SearchPageAction;
use App\Containers\Search\Actions\SearchPageSliceAction;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Search\Http\Requests\SearchArtsHttpRequest;
use App\Containers\Search\Http\Requests\SearchArtsSliceAjaxRequest;
use App\Ship\Dto\PaginationMetaDto;
use App\Ship\Parents\Controllers\HttpController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class SearchController extends HttpController
{

    /**
     * @param SearchArtsHttpRequest $request
     * @param SearchPageAction $action
     * @return Response
     *
     * @see \App\Containers\Search\Tests\Feature\Http\Controllers\ShowSearchIndexPageTest
     */
    public function index(SearchArtsHttpRequest $request, SearchPageAction $action): Response
    {
        try {
            $searchDto = new SearchDto($request->input());
            [$viewData, $pageMetaDto] = $action->run($searchDto);
            $this->setMeta($pageMetaDto->title)
                ->setRobots('noindex, follow');
            return response()->view('search::index', $viewData);
        } catch (Throwable $e) {
            Log::error($e);
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
        //TODO-misha вынести и объединить с кодом из cell;
        try {
            $pageNum = $request->page;
            $searchDto = new SearchDto($request->input());
            [$getCellTaggedResultDto, $isLastSlice] = $action->run($pageNum, $searchDto);
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
            Log::error($e);
            abort(500);
        }
    }

}

