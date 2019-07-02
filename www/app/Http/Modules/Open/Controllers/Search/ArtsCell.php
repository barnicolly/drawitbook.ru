<?php

namespace App\Http\Modules\Open\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Libraries\Template;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Search\SearchBySeoTag;
use App\UseCases\Search\SearchByTags;
use Illuminate\Http\Request;
use MetaTag;
use Validator;
use Breadcrumbs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ArtsCell extends Controller
{

    public function __construct()
    {

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

        $cacheName = 'arts.cell.tagged.' . $tag . '.' . $pageNum;
        if (!isLocal()) {
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

        $searcherByTags = new SearchByTags(1000);
        $relativePictureIds = $searcherByTags->searchRelatedPicturesIds([$tagInfo->id]);
        if (!$relativePictureIds) {
            abort(404);
        }

        $viewData = [];

        $perPage = 50;

        $countSearchResults = count($relativePictureIds);
        $relativePictureIds = array_slice($relativePictureIds, ($pageNum - 1) * $perPage, $perPage);

        $relativePictures = new GetPicturesWithTags($relativePictureIds);
        $relativePictures = $relativePictures->get();

        $paginate = new LengthAwarePaginator($relativePictures->forPage($pageNum, $perPage), $countSearchResults, $perPage, $pageNum, ['path' => route('arts.cell.tagged', $tag)]);

        $viewData['paginate'] = $paginate ?? [];
        $title = 'Рисунки по клеточкам «' . mbUcfirst($tagInfo->name) . '»‎';
        $description = 'Рисунки по клеточкам - ' . mbUcfirst($tagInfo->name) . '. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
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
        }
        if (empty($viewData['canonical'])) {
            $viewData['canonical'] = '';
        }
        MetaTag::set('image', asset('arts/d4/11/d4113a118447cb7650a7a7d84b45b153.jpeg'));
        $viewData['tag'] = $tagInfo;
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        $viewData['links'] = $this->_getPaginateLinks($pageNum, (int)($countSearchResults / $perPage) + 1, route('arts.cell.tagged', $tag));
        $page = $template->loadView('Open::search.cell.tagged', $viewData);
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
