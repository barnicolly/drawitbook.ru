<?php

namespace App\Http\Modules\Content\Controllers;

use App\Enums\Lang;
use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Paginator\PaginatorService;
use App\Services\Route\RouteService;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use App\Services\Translation\TranslationService;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Search extends Controller
{
    private $searchService;
    private $seoService;
    private $routeService;
    private $artsService;
    private $tagsService;
    private $translationService;

    public function __construct(
        SearchService $searchService,
        SeoService $seoService,
        RouteService $routeService,
        ArtsService $artsService,
        TranslationService $translationService,
        TagsService $tagsService
    ) {
        $this->searchService = $searchService;
        $this->seoService = $seoService;
        $this->routeService = $routeService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->translationService = $translationService;
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
            $viewData['popularTags'] = $this->getPopularTags();
        }
        $alternateLinks = $this->getAlternateLinks();
        $viewData['alternateLinks'] = $alternateLinks;
        $viewData['searchQuery'] = !empty($filters['query']) && is_string($filters['query']) ? $filters['query'] : '';
        $viewData['filters'] = $filters;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['countLeftArts'] = $countLeftArts;
        $viewData['countRelatedArts'] = $countSearchResults;
        $viewData['arts'] = $relativeArts;
        $locale = app()->getLocale();
        if (!$isLastSlice) {
            $countLeftArtsText = $this->translationService->getPluralForm($countLeftArts, Lang::fromValue($locale));
        }
        $viewData['leftArtsText'] = $countLeftArtsText ?? null;
        SEOTools::setCanonical($this->routeService->getRouteSearch());
        //TODO-misha добавить генерацию title;
        SEOTools::setTitle('Поиск по сайту');
        SEOMeta::setRobots('noindex, follow');
        return view('Content::search.index', $viewData)->render();
    }

    private function getAlternateLinks(): array
    {
        $links = [];
        $links[] = [
            'lang' => Lang::RU,
            'href' => $this->routeService->getRouteSearch([], true, Lang::RU),
        ];
        $links[] = [
            'lang' => Lang::EN,
            'href' => $this->routeService->getRouteSearch([], true, Lang::EN),
        ];
        return $links;
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
            $locale = app()->getLocale();
            if (!$isLastSlice) {
                $countLeftArtsText = $this->translationService->getPluralForm($countLeftArts, Lang::fromValue($locale));
            }
            $result = [
                'data' => [
                    'html' => view('Arts::template.stack_grid.elements', $viewData)->render(),
                    'page' => $pageNum,
                    'countLeftArtsText' => $countLeftArtsText ?? null,
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
        $relativeArtIds = [];
        try {
            if ($query) {
                $relativeArtIds = $this->searchService
                    ->setLimit(1000)
                    ->searchByQuery($query);
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

    private function getPopularTags(): array
    {
        $locale = app()->getLocale();
        $popularTags = $this->tagsService->getPopular($locale);
        return $this->tagsService->setLinkOnTags($popularTags);
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

