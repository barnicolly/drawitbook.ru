<?php

namespace App\Http\Modules\Open\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Entities\Spr\SprTagsModel;
use App\Http\Modules\Open\Requests\Search\SearchRisunkiPoKletochkamRequest;
use App\Libraries\Template;
use App\UseCases\Picture\CheckExistPictures;
use App\UseCases\Picture\GetPicture;
use App\UseCases\Picture\GetPicturesWithTags;
use App\UseCases\Picture\GetTagsFromPicture;
use App\UseCases\Search\SearchByTags;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use MetaTag;
use Validator;
use Breadcrumbs;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use sngrl\SphinxSearch\SphinxSearch;
use Illuminate\Support\Facades\Log;

class Search extends Controller
{

    public function index(Request $request)
    {
        $template = new Template();
        $tags = $request->input('tag') ?? [];
        $targetSimilarId = $request->input('similar') ?? 0;
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
            'similar' => $targetSimilarId,
        ], [
            'query' => 'string|max:255',
            'similar' => 'int',
            'tags' => 'array',
            'tags.*' => 'string',
        ]);
        if ($validator->fails()) {
            abort(404);
        }
        $query = strip_tags($query);
        $relativePictures = [];
        $countSearchResults = 0;
        if ($query || $tags || $targetSimilarId) {
            if ($query || $tags) {
                $relativePictureIds = $this->_searchByQuery($query, $tags);
                if ($relativePictureIds) {
                    $countSearchResults = count($relativePictureIds);
                    $page = $request->input('page');
                    $perPage = DEFAULT_PER_PAGE;
                    if (!$page) {
                        $page = 1;
                    }
                    $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);

                    if (!$relativePictureIds) {
                        abort(404);
                    }
                    $relativePictures = PictureModel::with(['tags'])
                        ->whereIn('id', $relativePictureIds)
                        ->get();

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
            } elseif ($targetSimilarId) {
                $getPicture = new GetPicture($targetSimilarId);
                $picture = $getPicture->getCached();
                $getTagsFromPictures = new GetTagsFromPicture();
                [$shown, $hidden] = $getTagsFromPictures->getTagIds($picture);
                $relativePictures = [];
                if ($shown || $hidden) {
                    $search = new SearchByTags(50);
                    $relativePictureIds = $search->searchRelatedPicturesIds($shown, $hidden);
                    if ($relativePictureIds) {
                        $countSearchResults = count($relativePictureIds);
                        $page = $request->input('page');
                        $perPage = DEFAULT_PER_PAGE;
                        if (!$page) {
                            $page = 1;
                        }
                        $relativePictureIds = array_slice($relativePictureIds, ($page - 1) * $perPage, $perPage);

                        $relativePictures = PictureModel::with(['tags'])
                            ->whereIn('id', $relativePictureIds)
                            ->get();

                        $relativePictures = $this->checkExistArts($relativePictures);

                        $paginate = new LengthAwarePaginator($relativePictures->forPage($page, $perPage), $countSearchResults, $perPage, $page, ['path' => url('search')]);
                        $paginate->appends(['similar' => $targetSimilarId]);
                    } else {
                        abort(404);
                    }
                }
            }

        }
        $viewData['filters'] = [
            'query' => $query,
            'tag' => $tags,
            'targetSimilarId' => $targetSimilarId,
        ];
        $viewData['paginate'] = $paginate ?? [];
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;
        //TODO-misha добавить title;

        MetaTag::set('robots', 'noindex');
        return $template->loadView('Open::search.index', $viewData);
    }

    public function risunkiPoKletochkam(SearchRisunkiPoKletochkamRequest $request)
    {
        $template = new Template();

        $data = $request->validated();
        $filters = [];
        if (!$filters) {

        }
        $relativePictures = [];
        $countSearchResults = 0;

        $viewData['filters'] = [
//            'query' => $query,
//            'tag' => $tags,
        ];
//        $viewData['paginate'] = $paginate ?? [];
        $viewData['countRelatedPictures'] = $countSearchResults;
        $viewData['relativePictures'] = $relativePictures;

        Breadcrumbs::for('home', function ($trail) {
            $trail->push('Главная', '/');
        });

        Breadcrumbs::for('risunkiPoKletochkam', function ($trail) {
            $trail->parent('home');
            $trail->push('Рисунки по клеточкам', '/risunki-po-kletochkam');
        });

        Breadcrumbs::for('search.risunkiPoKletochkam', function ($trail, $tag) {
            $trail->parent('risunkiPoKletochkam');
            $trail->push('Поиск', '/risunki-po-kletochkam/search');
            if ($tag) {
                $trail->push($tag);
            }
        });

        MetaTag::set('robots', 'noindex');
        return $template->loadView('Open::search.index', $viewData);
    }

    public function searchRelatedPicturesIds(array $shown, array $hidden)
    {
        $sphinx = new SphinxSearch();
        $sphinx->search('', 'drawItBookSearchByTag')
            ->limit(15)
            ->setFieldWeights(
                array(
                    'hidden_tag' => 3,
                    'tag' => 8,
                )
            )
            ->setSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, '@relevance DESC')
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED);
        if ($hidden) {
            $sphinx->filter('hidden_tag', $hidden);
        }
        if ($shown) {
            $sphinx->filter('tag', $shown);
        }
        $results = $sphinx->query();
        if (!empty($results['matches'])) {
            $pictureIds = array_keys($results['matches']);
            return $pictureIds;
        }
        return [];
    }

    public function checkExistArts(Collection $pictures)
    {
        foreach ($pictures as $key => $picture) {
            if (!file_exists(base_path('public/content/arts/') . $picture->path)) {
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
