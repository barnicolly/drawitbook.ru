<?php

declare(strict_types=1);

namespace App\Containers\Search\Http\Controllers;

use App\Containers\Picture\Tasks\PictureTag\GetTagsNamesTask;
use App\Containers\Search\Actions\SearchPageAction;
use App\Containers\Search\Actions\SearchPageSliceAction;
use App\Containers\Search\Data\Dto\GetAutocompleteTagsResultDto;
use App\Containers\Search\Data\Dto\SearchDto;
use App\Containers\Search\Http\Requests\SearchArtsHttpRequest;
use App\Containers\Search\Http\Requests\SearchArtsSliceAjaxRequest;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Parents\Resources\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

final class SearchController extends HttpController
{
    /**
     * @see \App\Containers\Search\Tests\Feature\Http\Controllers\ShowSearchIndexPageTest
     */
    public function index(SearchArtsHttpRequest $request, SearchPageAction $action): Response
    {
        $searchDto = new SearchDto($request->input());
        [$viewData, $pageMetaDto] = $action->run($searchDto);
        $this->setMeta($pageMetaDto->title)
            ->setRobots('noindex, follow');
        return response()->view('search::index', $viewData);
    }

    /**
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
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function autocomplete(GetTagsNamesTask $task): JsonResponse
    {
        $resultDto = new GetAutocompleteTagsResultDto(
            [
                'items' => $task->run(app()->getLocale()),
            ]
        );
        return JsonResource::make($resultDto)
            ->response();
    }
}
