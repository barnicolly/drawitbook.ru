<?php

namespace App\Console\Commands;

use App\Services\Posting\WallPostService;
use Illuminate\Console\Command;

class VkPosting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vk:posting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Постинг изображения в ВК';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $postingService = new WallPostService();
        $postingService->broadcast();
        $this->info('Запостил');
    }
}
