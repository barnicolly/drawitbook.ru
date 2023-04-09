<?php

namespace App\Containers\Seo\Console;

use App\Containers\Seo\Tasks\CreateSitemapTask;
use Illuminate\Console\Command;

class CreateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    public function handle(): void
    {
        app(CreateSitemapTask::class)->run();
    }
}
