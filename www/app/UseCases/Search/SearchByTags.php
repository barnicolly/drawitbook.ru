<?php

namespace App\UseCases\Search;

use App\Entities\Picture\PictureModel;
use Illuminate\Support\Facades\DB;
use sngrl\SphinxSearch\SphinxSearch;

class SearchByTags
{
    private $_limit;

    public function __construct(int $limit = 15)
    {
        $this->_limit = $limit;
    }

    public static function searchPicturesByTagId(int $tagId)
    {
        $results = DB::table('picture')
            ->select('picture.id')
            ->join('picture_tags', 'picture_tags.picture_id', '=', 'picture.id')
            ->whereRaw('picture_tags.tag_id = ?', [$tagId])
            ->where('picture.is_del', '=', NON_DELETED_ROW)
            ->limit(1000)
            ->get();
        $results = collect($results)->map(function ($x) {
            return (array) $x;
        })->toArray();
        if ($results) {
            return array_column($results, 'id');
        }
        return [];
    }

    public function searchRelatedPicturesIds(array $shown, array $hidden = [])
    {
        $sphinx = new SphinxSearch();
        $sphinx->search('', 'drawItBookSearchByTag')
            ->limit($this->_limit)
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
            return array_keys($results['matches']);
        }
        return [];
    }

}
