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
use sngrl\SphinxSearch\SphinxSearch;
use Illuminate\Pagination\LengthAwarePaginator;

class ArtsCell extends Controller
{

    public function __construct()
    {

    }

    public function tagged(string $tag, Request $request)
    {
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

        $page = $request->input('page');
        if (!is_null($request->input('page')) && $page <= 0) {
            abort(404);
        }
        $perPage = 50;
        if (!$page) {
            $page = 1;
        }
        $countSearchResults = count($relativePictureIds);
        $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);

        $relativePictures = new GetPicturesWithTags($relativePictureIds);
        $relativePictures = $relativePictures->get();

        $paginate = new LengthAwarePaginator($relativePictures->forPage($page, $perPage), $countSearchResults, $perPage, $page, ['path' => route('arts.cell.tagged', $tag)]);

        $viewData['paginate'] = $paginate ?? [];
        $title = 'Рисунки по клеточкам «' . mbUcfirst($tagInfo->name) . '»‎';
        $description = 'Рисунки по клеточкам - ' . mbUcfirst($tagInfo->name) . '. Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.';
        if ($page !== 1) {
            MetaTag::set('robots', 'noindex, follow');
            MetaTag::set('title', $title . ' - Страница ' . $page);
            MetaTag::set('description', $description  . ' Страница - ' . $page);
        } else {
            MetaTag::set('title', 'Рисунки по клеточкам «' . mbUcfirst($tagInfo->name) . '»‎ ');
            MetaTag::set('title', $title);
            MetaTag::set('description', $description);
        }

        $viewData['tag'] = $tagInfo;
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        $viewData['links'] = $this->_getPaginateLinks($page, (int)($countSearchResults / $perPage) + 1, route('arts.cell.tagged', $tag));
        return $template->loadView('Open::search.cell.tagged', $viewData);
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
