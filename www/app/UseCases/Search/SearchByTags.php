<?php

namespace App\UseCases\Search;

use sngrl\SphinxSearch\SphinxSearch;

class SearchByTags
{
    private $_limit;

    public function __construct(int $limit = 15)
    {
        $this->_limit = $limit;
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
