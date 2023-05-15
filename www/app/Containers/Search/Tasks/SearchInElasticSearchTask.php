<?php

namespace App\Containers\Search\Tasks;

use App\Containers\Search\Contracts\SearchContract;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SearchInElasticSearchTask extends Task
{
    private int $limit = 1000;

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function run(string $query, SearchContract $model, string $locale): ?array
    {
        /** @var Elasticsearch $items */
        $items = $this->elasticsearch
            ->search([
                'index' => $model->getSearchIndex(),
                'type' => $model->getSearchType(),
                'body' => $this->formQuery($query, $locale),
            ]);
        $items = $items->asArray();
        if ($items !== []) {
            return Arr::pluck($items['hits']['hits'], '_id');
        }
        return null;
    }

    private function formQuery(string $query, string $locale): array
    {
        $field = $locale === LangEnum::RU ? 'tags_ru' : 'tags_en';
        $words = preg_split("/\s/", $query, -1, PREG_SPLIT_NO_EMPTY);
        $query = implode(' ', $words);
        if (count($words) === 1) {
            $query = Str::start($query, '*');
            $query = Str::finish($query, '*');
            $subQuery = '{
                "wildcard": {
                    "%s.name": "%s"
                }
            }';
        } else {
            $subQuery = '{
                "bool": {
                  "must": [
                    { "match": {"%s.name": "%s"}}
                  ]
                }
            }';
        }
        $subQuery = sprintf($subQuery, $field, $query);
        $string = '{
          "size": %d,
          "query": {
            "nested": {
              "path": "%s",
              "query": %s
            }
          }
        }';
        $string = sprintf($string, $this->limit, $field, $subQuery);
        return json_decode($string, true);
    }
}
