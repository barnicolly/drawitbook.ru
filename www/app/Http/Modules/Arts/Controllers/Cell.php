<?php

namespace App\Http\Modules\Arts\Controllers;

use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Paginator\PaginatorService;
use App\Services\Route\RouteService;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
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

    public function __construct(
        RouteService $routeService,
        ArtsService $artsService,
        SeoService $seoService,
        SearchService $searchService,
        TagsService $tagsService
    ) {
        $this->breadcrumbs = new CollectionAlias();
        $this->routeService = $routeService;
        $this->seoService = $seoService;
        $this->artsService = $artsService;
        $this->tagsService = $tagsService;
        $this->searchService = $searchService;
    }

    public function index()
    {
        $arts = $this->artsService->getInterestingArts(0, 25);
        foreach ($arts as $index => $art) {
            $arts[$index] = $this->seoService->setArtAlt($art);
        }
        [$title, $description] = $this->seoService->formTitleAndDescriptionCellIndex();
        $this->addBreadcrumb('Рисунки по клеточкам');
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
        $pageNum = 1;
        $tagInfo = $this->tagsService->getByTagSeoName($tag);
        if (!$tagInfo) {
            abort(404);
        }
        try {
            $viewData = $this->formViewData($tagInfo['id'], $pageNum);
        } catch (NotFoundRelativeArts $e) {
            return abort(404);
        }
        $viewData['tag'] = $tagInfo;
        $viewData['canonical'] = $this->routeService->getRouteArtsCellTagged($tag);
        $countSearchResults = $viewData['countRelatedArts'];
        $relativeArts = $viewData['arts'];
        [$title, $description] = $this->seoService->formCellTaggedTitleAndDescription($countSearchResults, $tagInfo['name']);
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        $firstArt = getFirstItemFromArray($relativeArts);
        if ($firstArt) {
            $this->setShareImage(getArtsFolder() . $firstArt['path']);
        }
        $this->addBreadcrumb('Рисунки по клеточкам', $this->routeService->getRouteArtsCell());
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
            $tagInfo = $this->tagsService->getByTagSeoName($tag);
            if (!$tagInfo) {
                throw new Exception('Не найден tag');
            }
            $viewData = $this->formViewData($tagInfo['id'], $pageNum);
            $countLeftArts = $viewData['countLeftArts'];
            $isLastSlice = $viewData['isLastSlice'];
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
        if ($relativeArts) {
            $relativeArts = $this->seoService->setArtsAlt($relativeArts);
        }
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
