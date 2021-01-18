<?php

namespace App\Http\Modules\Arts\Controllers;

use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Paginator\PaginatorService;
use App\Services\Route\RouteService;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use App\Traits\BreadcrumbsTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Breadcrumbs;
use MetaTag;
use Throwable;
use Tightenco\Collect\Support\Collection as CollectionAlias;
use Validator;

class Cell extends Controller
{

    use BreadcrumbsTrait;

    private $routeService;
    private $artsService;
    private $seoService;

    public function __construct(RouteService $routeService, ArtsService $artsService, SeoService $seoService)
    {
        $this->breadcrumbs = new CollectionAlias();
        $this->routeService = $routeService;
        $this->seoService = $seoService;
        $this->artsService = $artsService;
    }

    public function index()
    {
        $pictures = $this->artsService->getInterestingArts(0, 25);
        $checkExistPictures = new CheckExistPictures($pictures);
        $pictures = $checkExistPictures->check();
        $title = 'Рисунки по клеточкам | Drawitbook.ru';
        $description = 'Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
        $this->addBreadcrumb('Рисунки по клеточкам');
        $viewData = [
            'tagged' => $this->formTagUrlPrefix(),
            'relativePictures' => $pictures,
            'breadcrumbs' => $this->breadcrumbs,
        ];
        MetaTag::set('title', $title);
        MetaTag::set('image', formDefaultShareArtUrlPath());
        MetaTag::set('description', $description);
        return view('Arts::cell.index', $viewData);
    }

    public function tagged(string $tag)
    {
        $pageNum = 1;
        $tagInfo = (new TagsService())->getByTagSeoName($tag);
        if (!$tagInfo) {
            abort(404);
        }
        try {
            $viewData = $this->formViewData($tagInfo->id, $pageNum);
        } catch (NotFoundRelativeArts $e) {
            return abort(404);
        }
        $viewData['tag'] = $tagInfo;
        $viewData['canonical'] = route('arts.cell.tagged', $tag);
        $countSearchResults = $viewData['countRelatedPictures'];
        $relativePictures = $viewData['pictures'];
        [$title, $description] = $this->formCategoryTitleAndDescription($countSearchResults, $tagInfo->name);
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        $firstPicture = $relativePictures->first();
        if ($firstPicture) {
            MetaTag::set('image', formArtUrlPath($firstPicture->path));
        }
        $this->addBreadcrumb('Рисунки по клеточкам', $this->routeService->getRouteArtsCell());
        $this->addBreadcrumb(mbUcfirst($tagInfo->name));
        $viewData['breadcrumbs'] = $this->breadcrumbs;
        $page = view('Arts::cell.tagged', $viewData)->render();
        return $page;
    }

    public function slice(string $tag, Request $request)
    {
        $rules = [
            'page' => [
                'required',
                'integer',
            ],
        ];
        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return abort(404);
        }
        $pageNum = (int) $request->input('page');
        try {
            $tagInfo = (new TagsService())->getByTagSeoName($tag);
            if (!$tagInfo) {
                throw new Exception('Не найден tag');
            }
            $viewData = $this->formViewData($tagInfo->id, $pageNum);
            $countLeftPictures = $viewData['countLeftPictures'];
            $isLastSlice = $viewData['isLastSlice'];
            $countLeftPicturesText = $countLeftPictures >= 0
                ? pluralForm($countLeftPictures, ['рисунок', 'рисунка', 'рисунков'])
                : '';
            $result = [
                'data' => [
                    'html' => view('Arts::template.stack_grid.elements', $viewData)->render(),
                    'page' => $pageNum,
                    'countLeftPicturesText' => $countLeftPicturesText,
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

    private function formViewData(int $tagId, int $pageNum)
    {
        [$relativePictureIds, $countSearchResults, $isLastSlice, $countLeftPictures] = $this->formSlicePictureIds(
            $tagId,
            $pageNum
        );
        if (!$relativePictureIds) {
            throw new NotFoundRelativeArts();
        }
        $relativePictures = $this->formRelativePictures($relativePictureIds);
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['pictures'] = $relativePictures;
        $viewData['countLeftPictures'] = $countLeftPictures;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['tagged'] = $this->formTagUrlPrefix();
        $viewData['page'] = $pageNum;
        return $viewData;
    }

    private function formTagUrlPrefix()
    {
        return route('arts.cell.tagged', '');
    }

    private function formSlicePictureIds(int $tagId, int $pageNum): array
    {
        $relativePictureIds = (new SearchService(1000))->searchPicturesByTagId($tagId);
        return (new PaginatorService())->formSlice($relativePictureIds, $pageNum);
    }

    private function formCategoryTitleAndDescription(int $countSearchResults, string $tagName): array
    {
        $tagName = mbUcfirst($tagName);
        $prefix = 'Рисунки по клеточкам';
        $title = $this->seoService->createCategoryTitle($prefix, $tagName, $countSearchResults);
        $description = $this->seoService->createCategoryDescription($prefix, $tagName, $countSearchResults);
        return [$title, $description];
    }

    private function formRelativePictures(array $relativePictureIds): Collection
    {
        $relativePictures = (new GetPicturesWithTags($relativePictureIds))->get();
        if ($relativePictures) {
            foreach ($relativePictures as $index => $relativePicture) {
                $this->seoService->setArtAlt($relativePicture);
            }
        }
        return $relativePictures;
    }

}
