<?php

namespace App\Http\Modules\Arts\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Picture\PictureModel;
use App\Libraries\Template;
use App\Services\Seo\SeoService;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicturesWithTags;
use App\Services\Search\SearchBySeoTag;
use App\Services\Search\SearchByTags;
use App\Services\Tags\TagsService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use MetaTag;
use Throwable;
use Validator;
use Breadcrumbs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class Cell extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $template = new Template();
        $pictures = Cache::remember(
            'pictures.popular',
            60 * 60,
            function () {
                return PictureModel::take(25)
                    ->where('is_del', '=', 0)
                    ->where('in_common', '=', IN_MAIN_PAGE)
                    ->with(['tags'])->get();
            }
        );
        $checkExistPictures = new CheckExistPictures($pictures);
        $pictures = $checkExistPictures->check();
        $viewData['relativePictures'] = $pictures;
        $title = 'Рисунки по клеточкам | Drawitbook.ru';
        $description = 'Рисунки по клеточкам. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
        MetaTag::set('title', $title);
        MetaTag::set('image', asset('content/arts/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg'));
        MetaTag::set('description', $description);
        return $template->loadView('Arts::cell.index', $viewData);
    }

    public function tagged(string $tag, Request $request)
    {
        $pageNum = $request->input('page');
        //TODO-misha добавить валидацию;
        //TODO-misha не использовать get параметры;
        if (!$pageNum) {
            $pageNum = 1;
        } else {
            $pageNum = (int) $pageNum;
        }
        if (!$pageNum) {
            return abort(404);
        }
        $cacheName = 'arts.cell.tagged.' . $tag . '.' . $pageNum;
        if (!isLocal() && empty(session('is_admin'))) {
            $page = Cache::get($cacheName);
            if ($page) {
                return $page;
            }
        }
        $template = new Template();

        $tagInfo = (new SearchBySeoTag($tag))->search();
        if (!$tagInfo) {
            abort(404);
        }
        [$relativePictureIds, $countSearchResults, $isLastSlice, $countLeftPictures] = $this->formSlicePictureIds(
            $tagInfo->id,
            $pageNum
        );
        if (!$relativePictureIds) {
            abort(404);
        }
        $relativePictures = $this->formRelativePictures($relativePictureIds);
        [$title, $description] = $this->formCategoryTitleAndDescription($countSearchResults, $tagInfo->name);
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        $firstPicture = $relativePictures->first();
        if ($firstPicture) {
            MetaTag::set('image', asset('content/arts/' . $firstPicture->path));
        }
        $viewData['tag'] = $tagInfo;
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        $viewData['countLeftPictures'] = $countLeftPictures;
        $viewData['isLastSlice'] = $isLastSlice;
        $viewData['tagged'] = $this->formTagUrlPrefix();
        $page = $template->loadView('Arts::cell.tagged', $viewData);
        if (!isLocal()) {
            Cache::put($cacheName, $page, config('cache.expiration'));
        }
        return $page;
    }

    public function slice(string $tag, Request $request)
    {
        $pageNum = $request->input('page');
        //TODO-misha добавить валидацию;
        //TODO-misha не использовать get параметры;
        if (!$pageNum) {
            return abort(404);
        }
        $pageNum = (int) $pageNum + 1;
        try {
            $tagInfo = (new SearchBySeoTag($tag))->search();
            if (!$tagInfo) {
               throw new Exception('Не найден tag');
            }
            $viewData = [];
            [$relativePictureIds, $countSearchResults, $isLastSlice, $countLeftPictures] = $this->formSlicePictureIds(
                $tagInfo->id,
                $pageNum
            );
            if (!$relativePictureIds) {
                throw new Exception('Не найден пулл изображений для paginate');
            }
            $relativePictures = $this->formRelativePictures($relativePictureIds);
            $viewData['countRelatedPictures'] = $countSearchResults;
            $viewData['pictures'] = $relativePictures;
            $viewData['countLeftPictures'] = $countLeftPictures;
            $viewData['isLastSlice'] = $isLastSlice;
            $viewData['tagged'] = $this->formTagUrlPrefix();
            $result = [
                'data' => [
                    'html' => view('Arts::template.stack_grid.elements', $viewData)->render(),
                    'page' => $pageNum,
                    'countLeftPicturesText' => pluralForm($countLeftPictures, ['рисунок', 'рисунка', 'рисунков']),
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

    private function formTagUrlPrefix()
    {
        return route('arts.cell.tagged', '');
    }

    private function formSlicePictureIds(int $tagId, int $pageNum): array
    {
        $relativePictureIds = SearchByTags::searchPicturesByTagId($tagId);
        if ($relativePictureIds) {
            $perPage = DEFAULT_PER_PAGE;
            $countSearchResults = count($relativePictureIds);
            $countSlices = ($countSearchResults / $perPage) + 1;
            $isLastSlice = (int) $countSlices === $pageNum;
            $relativePictureIds = array_slice($relativePictureIds, ($pageNum - 1) * $perPage, $perPage);
            $countLeftPictures = $countSearchResults - ($perPage * $pageNum);
        } else {
            $countSearchResults = 0;
            $isLastSlice = false;
            $countLeftPictures = 0;
        }
        return [$relativePictureIds, $countSearchResults, $isLastSlice, $countLeftPictures];
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
