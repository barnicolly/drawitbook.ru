<?php

namespace App\Services\Search;

use sngrl\SphinxSearch\SphinxSearch;

class SearchByQuery
{
    private $_limit;

    public function __construct(int $limit = 1000)
    {
        $this->_limit = $limit;
    }

    public function searchByQuery(string $query, array $tags = []): array
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
