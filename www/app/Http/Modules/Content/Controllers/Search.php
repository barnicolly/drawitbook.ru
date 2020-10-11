<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\Spr\SprTagsModel;
use App\Libraries\Template;
use App\Services\Arts\CheckExistPictures;
use App\Services\Arts\GetPicture;
use App\Services\Arts\GetTagsFromPicture;
use App\Services\Search\SearchByTags;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use MetaTag;
use Validator;
use Breadcrumbs;
use App\Entities\Picture\PictureModel;
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
                    $search = new SearchByTags(51);
                    $relativePictureIds = $search->searchRelatedPicturesIds($shown, $hidden);
                    if ($relativePictureIds) {
                        $relativePictureIds = array_diff($relativePictureIds, [$targetSimilarId]);
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
            if (!$relativePictures) {
                $pictures = PictureModel::take(10)
                    ->where('is_del', '=', 0)
                    ->where('in_common', '=', IN_MAIN_PAGE)
                    ->with(['tags'])->get();
                $checkExistPictures = new CheckExistPictures($pictures);
                $pictures = $checkExistPictures->check();
                $viewData['popularPictures'] = $pictures;
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
        return $template->loadView('Content::search.index', $viewData);
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
