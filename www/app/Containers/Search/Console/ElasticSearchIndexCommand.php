<?php

namespace App\Containers\Search\Console;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Search\Tasks\CreateElasticSearchIndexTask;
use App\Containers\Search\Tasks\FillElasticSearchIndexTask;
use App\Containers\Search\Tasks\DeleteElasticSearchIndexTask;
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

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->index();
    }

    //curl -X GET "elasticsearch:9200/_cat/indices/*?v=true&s=index&pretty"
    //curl -X GET "elasticsearch:9200/tags?pretty"
    private function index(): void
    {
        $index = (new PictureModel())->getSearchIndex();
        app(DeleteElasticSearchIndexTask::class)->run($index);
        $this->info("Deleted index - $index");
        app(CreateElasticSearchIndexTask::class)->run($index);
        $this->info("Created index - $index");
        $pictures = PictureModel::query()->with('tags')->get();
        $this->info('Indexing. This might take a while...');
        $bar = $this->output->createProgressBar(count($pictures));

        $bar->start();
        foreach ($pictures as $picture) {
            app(FillElasticSearchIndexTask::class)->run($picture);
            $bar->advance();
        }
        $bar->finish();
        $this->info("\nDone");
    }
}
