<?php

namespace App\Http\Modules\Content\Controllers;

use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Paginator\PaginatorService;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Search extends Controller
{
    private $searchService;
    private $seoService;
    private $artsService;
    private $tagsService;

    public function __construct(
        SearchService $searchService,
        SeoService $seoService,
        ArtsService $artsService,
        TagsService $tagsService
    ) {
        $this->searchService = $searchService;
        $this->seoService = $seoService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
    }

    public function index(Request $request)
    {
        $filters = $request->input();
        try {
            [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts] = $this->searchByFilters(
                $filters,
                1
            );
        } catch (Throwable $e) {
            abort(404);
        }
        if (!$relativeArts) {
            $viewData['popularArts'] = (new ArtsService())->getInterestingArts(0, 10);
        }
        $viewData['searchQuery'] = !empty($filters['query']) && is_string($filters['query']) ? $filters['query'] : '';
        $viewData['filters'] = $filters;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['countLeftArts'] = $countLeftArts;
        $viewData['countRelatedArts'] = $countSearchResults;
        $viewData['arts'] = $relativeArts;
        //TODO-misha добавить title;
        SEOTools::setTitle('Поиск по сайту');
        SEOMeta::setRobots('noindex, follow');
        return view('Content::search.index', $viewData)->render();
    }

    public function slice(Request $request)
    {
        //TODO-misha вынести и объединить с кодом из cell;
        $rules = [
            'page' => [
                'required',
                'integer',
            ],
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            abort(404);
        }
        $pageNum = (int) $request->input('page');
        try {
            [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts] = $this->searchByFilters(
                $request->input(),
                $pageNum
            );
            if (!$relativeArts) {
                throw new NotFoundRelativeArts();
            }
            $viewData = [
                'page' => $pageNum,
                'isLastSlice' => $isLastSlice,
                'countLeftArts' => $countLeftArts,
                'arts' => $relativeArts,
                'countRelatedArts' => $countSearchResults,
            ];
            $countLeftArtsText = $countLeftArts >= 0
                ? pluralForm($countLeftArts, ['рисунок', 'рисунка', 'рисунков'])
                : '';
            $result = [
                'data' => [
                    'html' => view('Arts::template.stack_grid.elements', $viewData)->render(),
                    'page' => $pageNum,
                    'countLeftArtsText' => $countLeftArtsText,
                    'isLastSlice' => $isLastSlice,
                ],
            ];
        } catch (Throwable $e) {
            $result = [
                'error' => 'Произошла ошибка на стороне сервера',
            ];
        }
        return response($result);
    }

    private function searchByFilters(array $filters, int $pageNum): array
    {
        $query = !empty($filters['query']) ? strip_tags($filters['query']) : '';
        $targetSimilarId = $filters['similar'] ?? 0;
        $relativeArtIds = [];
        try {
            if ($query) {
                $relativeArtIds = $this->searchService
                    ->setLimit(1000)
                    ->searchByQuery($query);
            } elseif ($targetSimilarId) {
                $artTags = $this->tagsService->getTagsByArtId($targetSimilarId, true);
                [$shown, $hidden] = $this->tagsService->separateTagsForHiddenAndShowIds($artTags);
                if ($shown || $hidden) {
                    $relativeArtIds = $this->searchService
                        ->setLimit(50)
                        ->searchRelatedPicturesIds($shown, $hidden, $targetSimilarId);
                }
            }
            if ($relativeArtIds) {
                [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts] = $this->formSlice(
                    $relativeArtIds,
                    $pageNum
                );
            } else {
                throw new NotFoundRelativeArts();
            }
        } catch (NotFoundRelativeArts $e) {
            $relativeArts = [];
            $countSearchResults = 0;
        }
        $isLastSlice = $isLastSlice ?? false;
        $countLeftArts = $countLeftArts ?? 0;
        return [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts];
    }

    private function formSlice(array $relativeArtIds, int $pageNum): array
    {
        [$relativeArtIds, $countSearchResults, $isLastSlice, $countLeftArts] = (new PaginatorService())
            ->formSlice($relativeArtIds, $pageNum);
        if (!$relativeArtIds) {
            throw new NotFoundRelativeArts();
        }
        $relativeArts = $this->artsService->getByIdsWithTags($relativeArtIds);
        return [$relativeArts, $countSearchResults, $isLastSlice, $countLeftArts];
    }
}

