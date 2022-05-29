<?php

namespace App\Containers\Search\Http\Controllers;

use App\Containers\Picture\Exceptions\NotFoundRelativeArts;
use App\Containers\Picture\Services\ArtsService;
use App\Containers\Search\Services\SearchService;
use App\Containers\Seo\Services\SeoService;
use App\Containers\Tag\Services\TagsService;
use App\Containers\Translation\Enums\LangEnum;
use App\Containers\Translation\Services\TranslationService;
use App\Ship\Parents\Controllers\HttpController;
use App\Ship\Services\Paginator\PaginatorService;
use App\Ship\Services\Route\RouteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class SearchHttpController extends HttpController
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
            $countLeftArtsText = $this->translationService->getPluralForm($countLeftArts, LangEnum::fromValue($locale));
        }
        $viewData['leftArtsText'] = $countLeftArtsText ?? null;
        //TODO-misha добавить генерацию title;
        [$title] = $this->seoService->formTitleAndDescriptionSearch();
        $this->setTitle($title)
            ->setRobots('noindex, follow');
        return view('search::index', $viewData)->render();
    }

    private function getAlternateLinks(): array
    {
        $links = [];
        $links[] = [
            'lang' => LangEnum::RU,
            'href' => $this->routeService->getRouteSearch([], true, LangEnum::RU),
        ];
        $links[] = [
            'lang' => LangEnum::EN,
            'href' => $this->routeService->getRouteSearch([], true, LangEnum::EN),
        ];
        return $links;
    }

    //    todo-misha вынести в отдельный контроллер api;
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
                $countLeftArtsText = $this->translationService->getPluralForm(
                    $countLeftArts,
                    LangEnum::fromValue($locale)
                );
            }
            $result = [
                'data' => [
                    'html' => view('picture::template.stack_grid.elements', $viewData)->render(),
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
