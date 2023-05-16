<?php

namespace App\Containers\Search\Tasks;

use App\Ship\Parents\Tasks\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class CreateElasticSearchIndexTask extends Task
{

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function run(string $index): void
    {
        $body = '{
            "mappings": {
                "properties": {
                   "tags": {
                       "type": "nested",
                       "properties" : {
                             "id" : {
                               "type" : "long"
                             },
                            "name" : {
                              "type" : "text",
                              "fields" : {
                                "keyword" : {
                                  "type" : "keyword",
                                  "ignore_above" : 256
                                }
                              }
                            },
                            "name_en" : {
                              "type" : "text",
                              "fields" : {
                                "keyword" : {
                                  "type" : "keyword",
                                  "ignore_above" : 256
                                }
                              }
                            },
                             "rating" : {
                                  "type" : "long"
                                }
                        }
                    }
                }
            }
        }';
        $params = [
            'index' => $index,
            'body' => $body,
        ];
        $this->elasticsearch->indices()->create($params);
    }
}
