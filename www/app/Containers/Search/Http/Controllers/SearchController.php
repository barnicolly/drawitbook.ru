<?php

namespace App\Containers\Search\Http\Controllers;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Search\Actions\SearchPageAction;
use App\Containers\Search\Actions\SearchPageSliceAction;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Search\Http\Requests\SearchArtsHttpRequest;
use App\Containers\Search\Http\Requests\SearchArtsSliceAjaxRequest;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Parents\Resources\JsonResource;
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
            throw $e;
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
        try {
            $searchDto = new SearchDto($request->input());
            [$getCellTaggedResultDto, $paginationMetaDto] = $action->run($searchDto);
            return JsonResource::make($getCellTaggedResultDto)
                ->withPaginationMeta($paginationMetaDto)
                ->response();
        } catch (NotFoundRelativeArts $e) {
            throw new NotFoundHttpException();
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }

}

