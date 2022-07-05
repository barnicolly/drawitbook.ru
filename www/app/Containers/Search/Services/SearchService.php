<?php

namespace App\Containers\Search\Services;

use App\Containers\Picture\Tasks\Picture\GetPicturesIdsByTagIdTask;
use Foolz\SphinxQL\Drivers\Mysqli\Connection;
use Foolz\SphinxQL\SphinxQL;

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
            $result = $this->searchByString($filters);
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

    private function searchByString(array $filters): array
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
        return $result->execute()
            ->fetchAllAssoc();
    }

    public function searchByTagId(int $tagId): array
    {
        return app(GetPicturesIdsByTagIdTask::class)->run($tagId, $this->limit);
    }

}
