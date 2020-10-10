<?php

namespace App\Http\Modules\Arts\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use App\Libraries\Template;
use App\UseCases\Picture\CheckExistPictures;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Search\SearchBySeoTag;
use App\UseCases\Search\SearchByTags;
use App\UseCases\Seo\Seo;
use Illuminate\Http\Request;
use MetaTag;
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
        $pictures = Cache::remember('pictures.popular', 60 * 60, function () {
            return PictureModel::take(25)
                ->where('is_del', '=', 0)
                ->where('in_common', '=', IN_MAIN_PAGE)
                ->with(['tags'])->get();
        });
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
        $addCanonical = false;
        if ($pageNum === '1') {
            $addCanonical = true;
        } else if (is_null($pageNum)) {
            $pageNum = 1;
        }
        $pageNum = (int)$pageNum;

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

        $searcher = new SearchBySeoTag($tag);
        $tagInfo = $searcher->search();

        if (!$tagInfo) {
            abort(404);
        }
        $relativePictureIds = SearchByTags::searchPicturesByTagId($tagInfo->id);
        if (!$relativePictureIds) {
            abort(404);
        }
        $viewData = [];

        $perPage = DEFAULT_PER_PAGE;

        $countSearchResults = count($relativePictureIds);
        $relativePictureIds = array_slice($relativePictureIds, ($pageNum - 1) * $perPage, $perPage);

        $relativePictures = new GetPicturesWithTags($relativePictureIds);
        $relativePictures = $relativePictures->get();

        $paginate = new LengthAwarePaginator($relativePictures->forPage($pageNum, $perPage), $countSearchResults, $perPage, $pageNum, ['path' => route('arts.cell.tagged', $tag)]);

        $viewData['paginate'] = $paginate ?? [];

        $title = Seo::createCategoryTitle('Рисунки по клеточкам', mbUcfirst($tagInfo->name), $countSearchResults);
        $description = Seo::createCategoryDescription('Рисунки по клеточкам', mbUcfirst($tagInfo->name), $countSearchResults);;
        if ($pageNum !== 1) {
            MetaTag::set('robots', 'noindex, follow');
            MetaTag::set('title', $title . ' - Страница ' . $pageNum);
            MetaTag::set('description', $description . ' Страница - ' . $pageNum);
        } else {
            MetaTag::set('title', $title);
            MetaTag::set('description', $description);
            if ($addCanonical) {
                $viewData['canonical'] = route('arts.cell.tagged', $tag);
            }
            $firstPicture = $relativePictures->first();
            if ($firstPicture) {
                MetaTag::set('image', asset('content/arts/' . $firstPicture->path));
            }
        }
        if (empty($viewData['canonical'])) {
            $viewData['canonical'] = '';
        }
        if ($relativePictures) {
            foreach ($relativePictures as $index => $relativePicture) {
                $tags = [];
                foreach ($relativePicture->tags as $tag) {
                    if ($tag->hidden === 0) {
                        $tags[] = mbUcfirst($tag->name);
                    }
                }
                if ($tags) {
                    $relativePicture->alt = 'Рисунки по клеточкам ➣ ' . implode(' ➣ ', $tags);
                }
            }
        }
        $viewData['tag'] = $tagInfo;
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        $viewData['links'] = $this->_getPaginateLinks($pageNum, (int)($countSearchResults / $perPage) + 1, route('arts.cell.tagged', $tag));
        $page = $template->loadView('Arts::cell.tagged', $viewData);
        if (!isLocal()) {
            Cache::put($cacheName, $page, config('cache.expiration'));
        }
        return $page;
    }

    private function _getPaginateLinks(int $page, int $maxPage, string $path)
    {
        $links = [];
        //в середине
        if ($page > 1 && $page !== $maxPage) {
            $links['prev'] = $path . '?' . 'page=' . ($page - 1);
            $links['next'] = $path . '?' . 'page=' . ($page + 1);
        } else if ($page === $maxPage) {
            //в конце
            $links['prev'] = $path . '?' . 'page=' . ($maxPage - 1);
        } elseif ($page === 1) {
            //в начале
            $links['next'] = $path . '?' . 'page=2';
        }
        return $links;
    }

}
