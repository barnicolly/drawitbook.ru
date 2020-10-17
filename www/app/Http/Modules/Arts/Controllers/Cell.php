<?php

namespace App\Http\Modules\Arts\Controllers;

use App\Exceptions\NotFoundRelativeArts;
use App\Http\Controllers\Controller;
use App\Services\Arts\ArtsService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Paginator\PaginatorService;
use App\Services\Search\SearchService;
use App\Services\Seo\SeoService;
use App\Services\Tags\TagsService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Breadcrumbs;
use MetaTag;
use Throwable;
use Validator;

class Cell extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $pictures = Cache::remember(
            'pictures.popular',
            60 * 60,
            function () {
                return (new ArtsService())->getInterestingArts(0, 25);
            }
        );
        $checkExistPictures = new CheckExistPictures($pictures);
        $pictures = $checkExistPictures->check();
        $viewData['relativePictures'] = $pictures;
        $viewData['tagged'] = $this->formTagUrlPrefix();
        $title = 'Рисунки по клеточкам | Drawitbook.ru';
        $description = 'Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
        MetaTag::set('title', $title);
        MetaTag::set('image', formDefaultShareArtUrlPath());
        MetaTag::set('description', $description);
        return view('Arts::cell.index', $viewData);
    }

    public function tagged(string $tag)
    {
        $pageNum = 1;
        $cacheName = 'arts.cell.tagged.' . $tag . '.' . $pageNum;
        if (!isLocal() && empty(session('is_admin'))) {
            $page = Cache::get($cacheName);
            if ($page) {
                return $page;
            }
        }
        $tagInfo = (new TagsService())->getByTagSeoName($tag);
        if (!$tagInfo) {
            abort(404);
        }
        try {
            $viewData = $this->formViewData($tagInfo->id, $pageNum);
            $viewData['tag'] = $tagInfo;
            $viewData['canonical'] = route('arts.cell.tagged', $tag);
        } catch (NotFoundRelativeArts $e) {
            return abort(404);
        }
        $countSearchResults = $viewData['countRelatedPictures'];
        $relativePictures = $viewData['pictures'];
        [$title, $description] = $this->formCategoryTitleAndDescription($countSearchResults, $tagInfo->name);
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        $firstPicture = $relativePictures->first();
        if ($firstPicture) {
            MetaTag::set('image', formArtUrlPath($firstPicture->path));
        }
        $page = view('Arts::cell.tagged', $viewData)->render();
        if (!isLocal()) {
            Cache::put($cacheName, $page, config('cache.expiration'));
        }
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
        $title = (new SeoService())->createCategoryTitle($prefix, $tagName, $countSearchResults);
        $description = (new SeoService())->createCategoryDescription($prefix, $tagName, $countSearchResults);
        return [$title, $description];
    }

    private function formRelativePictures(array $relativePictureIds): Collection
    {
        $relativePictures = (new GetPicturesWithTags($relativePictureIds))->get();
        if ($relativePictures) {
            foreach ($relativePictures as $index => $relativePicture) {
                (new SeoService())->setArtAlt($relativePicture);
            }
        }
        return $relativePictures;
    }

}
