<?php

namespace App\Containers\Search\Tasks;

use App\Containers\Search\Contracts\SearchContract;
use App\Ship\Parents\Tasks\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class FillElasticSearchIndexTask extends Task
{

    public function __construct(private readonly Client $elasticsearch)
    {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function run(SearchContract $model): void
    {
        $params = [
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ];
        $this->elasticsearch->index($params);
    }
}
