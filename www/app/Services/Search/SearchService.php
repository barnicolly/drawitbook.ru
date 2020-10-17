<?php

namespace App\Services\Search;

use Illuminate\Support\Facades\DB;
use sngrl\SphinxSearch\SphinxSearch;

class SearchService
{
    private $_limit;

    public function __construct(int $limit = 15)
    {
        $this->_limit = $limit;
    }

    public function searchPicturesByTagId(int $tagId)
    {
        $results = DB::table('picture')
            ->select('picture.id')
            ->join('picture_tags', 'picture_tags.picture_id', '=', 'picture.id')
            ->whereRaw('picture_tags.tag_id = ?', [$tagId])
            ->where('picture.is_del', '=', NON_DELETED_ROW)
            ->limit($this->_limit)
            ->get();
        $results = collect($results)->map(
            function ($x) {
                return (array) $x;
            }
        )->toArray();
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
                [
                    'hidden_tag' => 3,
                    'tag' => 8,
                ]
            )
            ->setSortMode(\Sphinx\SphinxClient::SPH_SORT_EXTENDED, '@weight DESC')
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

    public function searchByQuery(string $query, array $tags = [])
    {
        $sphinx = new SphinxSearch();
        $sphinx->search($query, 'drawitbookByQuery')
            ->limit($this->_limit)
            ->setSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE, '@relevance DESC')
            ->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED);
        if ($tags) {
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
