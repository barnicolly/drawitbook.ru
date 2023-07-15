<?php

namespace App\Containers\Search\Tasks;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use Barnicolly\ModelSearch\Contracts\SearchContract;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SearchInElasticSearchTask extends Task
{
    public function __construct(private readonly Client $elasticsearch)
    {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function run(string $query, SearchContract $model, string $locale, ?int $limit = null): ?array
    {
        /** @var Elasticsearch $items */
        $items = $this->elasticsearch
            ->search([
                'index' => $model->getSearchIndex(),
                'body' => $this->formQuery($query, $locale, $limit ?? 1000),
            ]);
        $items = $items->asArray();
        if ($items !== []) {
            return Arr::pluck($items['hits']['hits'], '_id');
        }
        return null;
    }

    private function formQuery(string $query, string $locale, int $limit): array
    {
        $query = Str::lower($query);
        $path = 'tags';
        $field = $locale === LangEnum::RU ? 'name' : 'name_en';
        $words = preg_split('#\\s#', $query, -1, PREG_SPLIT_NO_EMPTY);
        $queries = Arr::map($words, static function ($word) use ($path, $field): string {
            $word = Str::start($word, '*');
            $word = Str::finish($word, '*');
            $match = '{ "wildcard": {"%s.%s": "%s"}}';
            return sprintf($match, $path, $field, $word);
        });

        $query = implode(',', $queries);
        $subQuery = '{
                "bool": {
                  "should": [
                       %s
                  ],
                  "minimum_should_match": 1
                }
            }';
        $subQuery = sprintf($subQuery, $query);
        $string = '{
          "size": %d,
          "query": {
            "nested": {
              "path": "%s",
              "query": {
                "function_score": {
                    "query": %s,
                    "functions": [
                        {
                          "field_value_factor": {
                            "field": "%s.rating"
                          }
                        }
                      ]
                }
              }
            }
          }
        }';
        $string = sprintf($string, $limit, $path, $subQuery, $path);
        return json_decode($string, true, 512, JSON_THROW_ON_ERROR);
    }
}
