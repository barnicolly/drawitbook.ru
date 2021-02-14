<?php

namespace App\Http\Modules\Arts\Controllers;

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
use App\Traits\BreadcrumbsTrait;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Throwable;
use Tightenco\Collect\Support\Collection as CollectionAlias;
use Validator;

class Cell extends Controller
{

    use BreadcrumbsTrait;

    private $routeService;
    private $artsService;
    private $tagsService;
    private $seoService;
    private $searchService;
    private $translationService;

    public function __construct(
        RouteService $routeService,
        ArtsService $artsService,
        SeoService $seoService,
        SearchService $searchService,
        TranslationService $translationService,
        TagsService $tagsService
    ) {
        $this->breadcrumbs = new CollectionAlias();
        $this->routeService = $routeService;
        $this->seoService = $seoService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->searchService = $searchService;
        $this->translationService = $translationService;
    }

    public function index()
    {
        $arts = $this->artsService->getInterestingArts(0, 25);
        [$title, $description] = $this->seoService->formTitleAndDescriptionCellIndex();
        $this->addBreadcrumb(__('breadcrumbs.pixel_arts'));
        $viewData = [
            'arts' => $arts,
            'breadcrumbs' => $this->breadcrumbs,
        ];
        SEOTools::setTitle($title);
        $this->setShareImage(formDefaultShareArtUrlPath(true));
        SEOTools::setDescription($description);
        return response()->view('Arts::cell.index', $viewData);
    }

    public function tagged(string $tag)
    {
        $locale = app()->getLocale();
        $pageNum = 1;
        $tagInfo = $this->tagsService->getByTagSeoName($tag, $locale);
        if (!$tagInfo) {
            $alternativeLang = $locale === Lang::RU ? Lang::EN: Lang::RU;
            if ($locale === Lang::RU) {
                $tagInfo = $this->tagsService->getByTagSeoName($tag, $alternativeLang);
            } elseif ($locale === Lang::EN) {
                $tagInfo = $this->tagsService->getByTagSeoName($tag, $alternativeLang);
            }
            if (!empty($tagInfo)) {
                $tagInfo = $this->tagsService->getById($tagInfo['id']);
                $slug = $locale === Lang::RU
                    ? $tagInfo['seo']
                    : $tagInfo['slug_en'];
                if ($slug) {
                    return redirect($this->routeService->getRouteArtsCellTagged($slug), 301);
                }
            }
            abort(404);
        }
        try {
            $viewData = $this->formViewData($tagInfo['id'], $pageNum);
        } catch (NotFoundRelativeArts $e) {
            return abort(404);
        }
        if (!$viewData['isLastSlice']) {
            $leftArtsText = $this->translationService->getPluralForm($viewData['countLeftArts'], Lang::fromValue($locale));
        }
        $viewData['leftArtsText'] = $leftArtsText ?? null;
        $viewData['tag'] = $tagInfo;
        $viewData['canonical'] = $this->routeService->getRouteArtsCellTagged($tag);
        $countSearchResults = $viewData['countRelatedArts'];
        $relativeArts = $viewData['arts'];
        [$title, $description] = $this->seoService->formCellTaggedTitleAndDescription(
            $countSearchResults,
            $tagInfo['name']
        );
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        $firstArt = getFirstItemFromArray($relativeArts);
        if ($firstArt) {
            $this->setShareImage(getArtsFolder() . $firstArt['path']);
        }
        $this->addBreadcrumb(__('breadcrumbs.pixel_arts'), $this->routeService->getRouteArtsCell());
        $this->addBreadcrumb(mbUcfirst($tagInfo['name']));
        $viewData['breadcrumbs'] = $this->breadcrumbs;
        return response()->view('Arts::cell.tagged', $viewData);
    }

    public function slice(string $tag, Request $request)
    {
        $rules = [
            'page' => [
                'required',
                'integer',
            ],
        ];
        //TODO-misha вынести валадацию;
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $pageNum = (int) $request->input('page');
        try {
            $locale = app()->getLocale();
            $tagInfo = $this->tagsService->getByTagSeoName($tag, $locale);
            if (!$tagInfo) {
                throw new Exception('Не найден tag');
            }
            $viewData = $this->formViewData($tagInfo['id'], $pageNum);
            $isLastSlice = $viewData['isLastSlice'];
            if (!$isLastSlice) {
                $countLeftArtsText = $this->translationService->getPluralForm($viewData['countLeftArts'], Lang::fromValue($locale));
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
        return response()->json($result);
    }

    private function formViewData(int $tagId, int $pageNum): array
    {
        [$relativeArtIds, $countSearchResults, $isLastSlice, $countLeftArts] = $this->formSliceArtIds(
            $tagId,
            $pageNum
        );
        if (!$relativeArtIds) {
            throw new NotFoundRelativeArts();
        }
        $relativeArts = $this->artsService->getByIdsWithTags($relativeArtIds);
        $viewData['countRelatedArts'] = $countSearchResults;
        $viewData['arts'] = $relativeArts;
        $viewData['countLeftArts'] = $countLeftArts;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['page'] = $pageNum;
        return $viewData;
    }

    private function formSliceArtIds(int $tagId, int $pageNum): array
    {
        $relativePictureIds = $this->searchService
            ->setLimit(1000)
            ->searchByTagId($tagId);
        return (new PaginatorService())->formSlice($relativePictureIds, $pageNum);
    }

}
