<?php

namespace App\Containers\Search\Tasks;

use App\Ship\Parents\Tasks\Task;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class DeleteElasticSearchIndexTask extends Task
{

    public function __construct(private readonly Client $elasticsearch)
    {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function run(string $index): void
    {
        $params = [
            'index' => $index,
            'ignore_unavailable' => true,
        ];
        $this->elasticsearch->indices()->delete($params);
    }
}
