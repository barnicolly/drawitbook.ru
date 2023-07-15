<?php

namespace App\Containers\Search\Console;

use App\Containers\Picture\Models\PictureModel;
use Barnicolly\ModelSearch\Tasks\ElasticSearchCreateIndexTask;
use Barnicolly\ModelSearch\Tasks\ElasticSearchDeleteIndexTask;
use Barnicolly\ModelSearch\Tasks\ElasticSearchIndexModelTask;
use Illuminate\Console\Command;

class ElasticSearchIndexCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'search:index';

    /**
     * @var string
     */
    protected $description = 'Индексирование моделей для поиска';

    public function handle(): void
    {
        $this->index();
    }

    // curl -X GET "elasticsearch:9200/_cat/indices/*?v=true&s=index&pretty"
    // curl -X GET "elasticsearch:9200/pictures?pretty"
    private function index(): void
    {
        $index = (new PictureModel())->getSearchIndex();
        app(ElasticSearchDeleteIndexTask::class)->run($index);
        $this->info("Deleted index - {$index}");

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
        app(ElasticSearchCreateIndexTask::class)->run($index, $body);
        $this->info("Created index - {$index}");
        $pictures = PictureModel::query()->with('tags')->get();
        $this->info('Indexing. This might take a while...');
        $bar = $this->output->createProgressBar(count($pictures));

        $bar->start();
        foreach ($pictures as $picture) {
            app(ElasticSearchIndexModelTask::class)->run($picture);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nDone");
    }
}
