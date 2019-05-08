<?php

namespace App\Http\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Database\Models\Common\Spr\SprTagsModel;
use App\Libraries\Template;
use Illuminate\Http\Request;
use MetaTag;
use App\Http\Modules\Database\Models\Common\Picture\PictureModel;
use sngrl\SphinxSearch\SphinxSearch;
use Illuminate\Support\Facades\DB;
class Search extends Controller
{

    public function index(Request $request)
    {
        $template = new Template();
        $tags = $request->input('tag') ?? [];
        if (is_string($tags)) {
            $tags = [$tags];
        }
        //фильтрация
        $query = $request->input('query') ?? '';
        $relativePictures = [];
        if ($query || $tags) {
            $relativePictureIds = $this->_searchByQuery($query, $tags);
            if ($relativePictureIds) {
                $relativePictures = PictureModel::with(['tags'])
                    ->whereIn('id', $relativePictureIds)
                    ->get();
            }
        }
        $viewData['filters'] = [
            'query' => $query,
            'tag' => $tags,
        ];
        $viewData['relativePictures'] = $relativePictures;
        return $template->loadView('Content::search.index', $viewData);
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
//            if (count($pictureIds) < 20 && $hidden) {
//                $sphinx = new SphinxSearch();
//                $sphinx->search('', 'drawItBookSearchByTag')
//                    ->limit(20)
//                    ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED2)
//                    ->filter('hidden_tag', $hidden);
//                $resultsHidden = $sphinx->query();
//                if (!empty($resultsHidden['matches'])) {
//                    $pictureIds = array_merge($pictureIds, array_keys($results['matches']));
//                    $pictureIds = array_unique($pictureIds);
//                    $pictureIds = array_slice($pictureIds, 0, 20);
//                }
//            }

            return $pictureIds;
        }
        return [];
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
