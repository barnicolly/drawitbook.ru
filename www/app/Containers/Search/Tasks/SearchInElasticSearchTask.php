<?php

namespace App\Containers\Search\Tasks;

use App\Containers\Search\Contracts\SearchContract;
use App\Ship\Parents\Tasks\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Support\Arr;

class SearchInElasticSearchTask extends Task
{

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function run(string $query, SearchContract $model): ?array
    {
        /** @var Elasticsearch $items */
        $items = $this->elasticsearch
            ->search([
                'index' => $model->getSearchIndex(),
                'type' => $model->getSearchType(),
                'body' => $this->formQuery($query, $query),
            ]);
        $items = $items->asArray();
        if ($items !== []) {
            return Arr::pluck($items['hits']['hits'], '_id');
        }
        return null;
    }

    private function formQuery(string $query, string $suggestQuery): array
    {
        $string = "{\"query\":{\"query_string\":{\"fields\":[\"tags_ru\"],\"query\":\"{$query}\",\"analyzer\":\"simple\",\"default_operator\":\"AND\"}},\"suggest\":{\"suggester\":{\"text\":\"{$suggestQuery}\",\"term\":{\"field\":\"tags_ru\"}}}}";
        return json_decode($string, true);
    }
}
