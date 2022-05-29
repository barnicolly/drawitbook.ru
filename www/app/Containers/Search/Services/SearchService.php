<?php

namespace App\Containers\Search\Services;

use Foolz\SphinxQL\Drivers\Mysqli\Connection;
use Foolz\SphinxQL\SphinxQL;
use Illuminate\Support\Facades\DB;

class SearchService
{
    private $connection = null;
    private $index = 'drawitbookByQuery';
    private $limit = 15;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->connection->setParams(['host' => config('app.search_host_sphinx'), 'port' => 9306]);
    }

    public function setLimit(int $limit): SearchService
    {
        $this->limit = $limit;
        return $this;
    }

    public function searchByQuery(string $query): array
    {
        try {
            $filters = [
                'query' => $query,
            ];
            $result = $this->searchByString($filters, 0, 20);
            if (!empty($result)) {
                return array_column($result, 'id');
            }
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function searchRelatedPicturesIds(array $shown, array $hidden = [], int $excludeQuestionId = 0): array
    {
        try {
            $this->index = 'drawItBookSearchByTag';
            $result = (new SphinxQL($this->connection))
                ->select('id', 'weight() AS weight')
                ->option(
                    'field_weights',
                    [
                        'hidden_tag' => 3,
                        'tag' => 8,
                    ]
                )
                ->from($this->index)
                ->limit($this->limit);
            if (!empty($shown)) {
                $result->where('tag', 'IN', $shown);
            }
            if (!empty($hidden)) {
                $result->where('hidden_tag', 'IN', $hidden);
            }
            if ($excludeQuestionId) {
                $result->where('id', 'NOT IN', [$excludeQuestionId]);
            }
            $result = $result->execute()
                ->fetchAllAssoc();
            if (!empty($result)) {
                return array_column($result, 'id');
            }
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function searchByString(array $filters, int $excludeQuestionId = 0)
    {
        $result = (new SphinxQL($this->connection))
            ->select('id', 'query', 'weight() AS weight')
            ->from($this->index)
            ->limit($this->limit);

        $query = $filters['query'] ?? '';
        if ($query) {
            $exploded = explode(' ', $query);
            $exploded = array_filter(
                $exploded,
                function ($item) {
                    return $item !== '';
                }
            );
            $result->match('query', implode('||', $exploded), true);
        }
        if ($excludeQuestionId) {
            $result->where('id', 'NOT IN', [$excludeQuestionId]);
        }
        return $result->execute()
            ->fetchAllAssoc();
    }

//    todo-misha переместить в модель picture;
    public function searchByTagId(int $tagId): array
    {
        $results = DB::table('picture')
            ->select('picture.id')
            ->join('picture_tags', 'picture_tags.picture_id', '=', 'picture.id')
            ->whereRaw('picture_tags.tag_id = ?', [$tagId])
            ->where('picture.is_del', '=', NON_DELETED_ROW)
            ->limit($this->limit)
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

}
