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
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class RisunkiPoKletochkam extends Controller
{

    public function __construct()
    {
        Breadcrumbs::for('home', function ($trail) {
            $trail->push('Главная', '/', ['icon' => 'fa fa-home']);
        });

        Breadcrumbs::for('risunkiPoKletochkam', function ($trail) {
            $trail->parent('home');
            $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam');
        });

        Breadcrumbs::for('risunkiPoKletochkam.search', function ($trail) {
            $trail->parent('home');
            $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam/search');
        });

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
        Breadcrumbs::for('risunkiPoKletochkam.search.tagged', function ($trail, $tag) {
            $trail->parent('risunkiPoKletochkam.search');
            $trail->push($tag);
        });

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

        $paginate = new LengthAwarePaginator($relativePictures->forPage($page, $perPage), $countSearchResults, $perPage, $page, ['path' => route('risunkiPoKletochkam.tagged', $tag)]);

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
        $viewData['links'] = $this->_getPaginateLinks($page, (int)($countSearchResults / $perPage) + 1, route('risunkiPoKletochkam.tagged', $tag));
        return $template->loadView('Open::search.risunki_po_kletochkam.tagged', $viewData);
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

    public function search(Request $request)
    {
        $template = new Template();
        $tags = $request->input('tag') ?? [];
        if (is_string($tags)) {
            $tags = [$tags];
        }
        if (is_string($tags)) {
            $tags = [$tags];
        }
        $query = $request->input('query') ?? '';
        $validator = Validator::make([
            'tags' => $tags,
            'query' => $query,
        ], [
            'query' => 'string|max:255',
            'tags' => 'array',
            'tags.*' => 'string',
        ]);
        if ($validator->fails()) {
            abort(404);
        }
        $query = strip_tags($query);
        $relativePictures = [];
        $countSearchResults = 0;
        if ($query || $tags) {
            $relativePictureIds = $this->_searchByQuery($query, $tags);
            if ($relativePictureIds) {
                $countSearchResults = count($relativePictureIds);
                $page = $request->input('page');
                $perPage = 50;
                if (!$page) {
                    $page = 1;
                }
                $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);

                if (!$relativePictureIds) {
                    abort(404);
                }

                $relativePictures = new GetPicturesWithTags($relativePictureIds);
                $relativePictures = $relativePictures->get();

                $relativePictures = $this->checkExistArts($relativePictures);

                $paginate = new LengthAwarePaginator($relativePictures->forPage($page, $perPage), $countSearchResults, $perPage, $page, ['path' => url('search')]);

                if ($query) {
                    $paginate->appends(['query' => $query]);
                }
                if ($tags) {
                    foreach ($tags as $tag) {
                        $paginate->appends(['tag[]' => $tag]);
                    }
                }
            }
        }
        $viewData['filters'] = [
            'query' => $query,
            'tag' => $tags,
        ];
        $viewData['paginate'] = $paginate ?? [];
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;

        MetaTag::set('robots', 'noindex');
        return $template->loadView('Open::search.risunki_po_kletochkam.index', $viewData);
    }

    public function checkExistArts(Collection $pictures)
    {
        foreach ($pictures as $key => $picture) {
            if (!file_exists(base_path('public/arts/') . $picture->path)) {
                $pictures->forget($key);
                Log::info('Не найдено изображение', ['art' => $picture->toArray()]);
            }
        }
        return $pictures;
    }

    private function _searchByQuery(string $query, array $tags = [])
    {
        $sphinx = new SphinxSearch();
        $sphinx->search($query, 'drawitbookByQuery')
            ->limit(1000)
            ->setSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, '@relevance DESC')
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED);
        if ($tags) {
            $tags = SprTagsModel::whereIn('name', $tags)->pluck('id')->toArray();
            if (!$tags) {
                return [];
            }
            foreach ($tags as $item) {
                $sphinx->filter('tag', $item);
            }
        }
        $results = $sphinx->query();
        if (!empty($results['matches'])) {
            $pictureIds = array_keys($results['matches']);
            return $pictureIds;
        }
        return [];
    }


}
